<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('db_connection.php'); // Конектирање со база

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Мора да се најавите.");
}

$userID = $_SESSION['user_id'];

// Проверка дали е испратено campaign_id преку POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campaign_id'])) {
    $campaignID = intval($_POST['campaign_id']);

    // Проверка дали постои кампањата и дали е активна
    $campaignCheckSQL = "SELECT EndDate FROM campaigns WHERE CampaignID = ?";
    $stmt = $conn->prepare($campaignCheckSQL);
    $stmt->bind_param("i", $campaignID);
    $stmt->execute();
    $campaignResult = $stmt->get_result();

    if ($campaignResult->num_rows === 0) {
        $message = "Кампањата не постои.";
        $messageType = "danger";
    } else {
        $campaign = $campaignResult->fetch_assoc();
        $currentDate = date("Y-m-d");

        if ($campaign['EndDate'] < $currentDate) {
            $message = "Кампањата е веќе завршена.";
            $messageType = "warning";
        } else {
            // Проверка дали корисникот веќе се регистрирал во кампањата
            $checkSQL = "SELECT * FROM campaignbeneficiaries WHERE CampaignID = ? AND UserID = ?";
            $stmt = $conn->prepare($checkSQL);
            $stmt->bind_param("ii", $campaignID, $userID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = "Веќе сте пријавени за оваа кампања.";
                $messageType = "danger";
            } else {
                // Додавање на корисникот во кампањата
                $insertSQL = "INSERT INTO campaignbeneficiaries (CampaignID, UserID) VALUES (?, ?)";
                $stmt = $conn->prepare($insertSQL);
                $stmt->bind_param("ii", $campaignID, $userID);

                if ($stmt->execute()) {
                    // Ажурирање на бројот на пријавени корисници
                    $updateRegisteredUsersSQL = "UPDATE campaigns SET registered_users = registered_users + 1 WHERE CampaignID = ?";
                    $stmt = $conn->prepare($updateRegisteredUsersSQL);
                    $stmt->bind_param("i", $campaignID);

                    if ($stmt->execute()) {
                        $message = "Успешно се пријавивте за кампањата!";
                        $messageType = "success";
                    } else {
                        $message = "Успешно се пријавивте, но не можеше да се ажурира бројот на учесници.";
                        $messageType = "warning";
                    }
                } else {
                    $message = "Настана грешка при пријавувањето. Обидете се повторно.";
                    $messageType = "danger";
                }
            }
        }
    }
    $stmt->close();
} else {
    $message = "Невалидно барање.";
    $messageType = "danger";
}
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Пријавување за Кампања</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Пријавување за Кампања</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?= $messageType; ?> text-center">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="join-campaign.php" class="mt-4">
        <div class="mb-3">
            <label for="campaign_id" class="form-label">ID на Кампањата</label>
            <input type="number" class="form-control" id="campaign_id" name="campaign_id" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Пријави се</button>
    </form>

    <div class="mt-3">
        <a href="campaigns-read.php" class="btn btn-secondary w-100">Назад до Кампањи</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
