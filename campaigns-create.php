<?php 
require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Промени во полињата за кампања
    $Name = $_POST['Name'] ?? '';
    $Description = $_POST['Description'] ?? '';
    $StartDate = $_POST['StartDate'] ?? '';
    $EndDate = $_POST['EndDate'] ?? null;
    $TargetAmount = $_POST['TargetAmount'] ?? 0;
    $OrganizerID = $_POST['OrganizerID'] ?? null;
    $Status = 'pending'; // Статусот по дефолт ќе биде 'pending'

    // Проверка дали сите задолжителни полиња се пополнети
    if (!empty($Name) && !empty($Description) && !empty($StartDate) && !empty($TargetAmount) && $OrganizerID !== null) {
        // Внесување на кампањата во базата на податоци
        $stmt = $conn->prepare("INSERT INTO campaigns (Name, Description, StartDate, EndDate, TargetAmount, OrganizerID, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Извршување на SQL изјавата
        if ($stmt->execute([$Name, $Description, $StartDate, $EndDate, $TargetAmount, $OrganizerID, $Status])) {
            // Пренасочување кон страница што го информира корисникот дека настанот е на чекање
            header("Location: campaign_pending.php");
            exit();
        } else {
            // Грешка ако не е успешно додавање на кампањата
            $error = "Грешка при додавање на настан.";
        }
    } else {
        // Грешка ако не се пополнети сите задолжителни полиња
        $error = "Пополнете ги сите задолжителни полиња.";
    }
}
?>

<!-- Страница за креирање на кампања -->
<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Креирај Кампања</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Креирај Кампања</h1>

        <?php
        if (isset($error)) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>

        <form method="POST" action="campaigns-create.php">
        
            <div class="mb-3">
                <label for="Name" class="form-label">Име на кампањата</label>
                <input type="text" class="form-control" id="Name" name="Name" required>
            </div>
            <div class="mb-3">
                <label for="Description" class="form-label">Опис на кампањата</label>
                <textarea class="form-control" id="Description" name="Description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="StartDate" class="form-label">Почетен датум</label>
                <input type="date" class="form-control" id="StartDate" name="StartDate" required>
            </div>
            <div class="mb-3">
                <label for="EndDate" class="form-label">Краен датум</label>
                <input type="date" class="form-control" id="EndDate" name="EndDate">
            </div>
            <div class="mb-3">
                <label for="TargetAmount" class="form-label">Целна сума</label>
                <input type="number" class="form-control" id="TargetAmount" name="TargetAmount" required>
            </div>
            <div class="mb-3">
                <label for="OrganizerID" class="form-label">ID на организаторот</label>
                <input type="number" class="form-control" id="OrganizerID" name="OrganizerID" required>
            </div>
            <button type="submit" class="btn btn-primary">Креирај Кампања</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
