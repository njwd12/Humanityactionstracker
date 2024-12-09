<?php
require_once('db_connection.php'); // Connect to the database

// Start the session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Мора да се најавите.");
}

$userID = $_SESSION['user_id']; // Get the logged-in user's ID from session

// Check if campaign_id is set via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campaign_id'])) {
    $campaignID = intval($_POST['campaign_id']); // Safely retrieve CampaignID

    // Check if the campaign exists
    $campaignCheckSQL = "SELECT * FROM campaigns WHERE CampaignID = ?";
    $stmt = mysqli_prepare($conn, $campaignCheckSQL);
    mysqli_stmt_bind_param($stmt, "i", $campaignID);
    mysqli_stmt_execute($stmt);
    $campaignResult = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($campaignResult) === 0) {
        $message = "Кампањата не постои.";
        $messageType = "danger"; // Error message
    } else {
        // Check if the user exists (checking if the user exists in the users table)
        $userCheckSQL = "SELECT * FROM users WHERE UserID = ?";
        $stmt = mysqli_prepare($conn, $userCheckSQL);
        mysqli_stmt_bind_param($stmt, "i", $userID); // Check if the user exists
        mysqli_stmt_execute($stmt);
        $userResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($userResult) === 0) {
            $message = "Корисникот не постои.";
            $messageType = "danger"; // Error message
        } else {
            // Check if the user is already registered for this campaign
            $checkSQL = "SELECT * FROM campaignbeneficiaries WHERE CampaignID = ? AND UserID = ?";
            $stmt = mysqli_prepare($conn, $checkSQL);
            mysqli_stmt_bind_param($stmt, "ii", $campaignID, $userID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $message = "Веќе сте пријавени за оваа кампања.";
                $messageType = "danger"; // Error message
            } else {
                // Add the user to the campaign
                $insertSQL = "INSERT INTO campaignbeneficiaries (CampaignID, UserID) VALUES (?, ?)";
                $stmt = mysqli_prepare($conn, $insertSQL);
                mysqli_stmt_bind_param($stmt, "ii", $campaignID, $userID);

                if (mysqli_stmt_execute($stmt)) {
                    $message = "Успешно се пријавивте за кампањата!";
                    $messageType = "success"; // Success message
                } else {
                    $message = "Настана грешка при пријавувањето. Обидете се повторно.";
                    $messageType = "danger"; // Error message
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
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
