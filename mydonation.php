<?php
require_once('db_connection.php');
session_start();

// Проверка дали корисникот е најавен
if (!isset($_SESSION['user_id'])) {
    die("Морате да се најавите за да донрате.");
}

$donor_id = $_SESSION['user_id'];  // ID на корисникот од сесијата
$campaign_id = $_GET['campaign_id'];  // ID на кампањата која ја одбра корисникот

// Проверка за валидност на износот на донацијата
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];

    // Ако износот не е внесен или е невалиден
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        echo "<div class='alert alert-danger'>Мора да внесете валиден износ за донација.</div>";
    } else {
        // Вметнување на донацијата во базата
        $sql = "INSERT INTO donations (CampaignID, DonorID, Amount, DonationDate) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iid", $campaign_id, $donor_id, $amount);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Донацијата беше успешно внесена!</div>";
        } else {
            echo "<div class='alert alert-danger'>Грешка при внесувањето на донацијата: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Донирај за Кампања</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Донирај за Кампања</h1>

        <!-- Формата за внес на износ -->
        <form action="mydonation.php?campaign_id=<?php echo $campaign_id; ?>" method="POST">
            <div class="mb-3">
                <label for="amount" class="form-label">Износ на донација</label>
                <input type="number" class="form-control" id="amount" name="amount" required min="0.01" step="0.01">
            </div>
            <button type="submit" class="btn btn-primary">Донирај</button>
        </form>

        <div class="text-center mt-4">
            <a href="campaigns-read.php" class="btn btn-secondary">Назад на кампањите</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
