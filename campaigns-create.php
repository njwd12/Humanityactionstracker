<?php
require_once 'db_connection.php'; // Осигурај се дека имаш поврзување со базата

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = trim($_POST['Name']);
    $Description = trim($_POST['Description']);
    $StartDate = $_POST['StartDate'];
    $EndDate = !empty($_POST['EndDate']) ? $_POST['EndDate'] : NULL; // Дозволи NULL вредност ако не е внесена
    $TargetAmount = $_POST['TargetAmount'];
    $OrganizerID = $_POST['OrganizerID'];
    $Status = 'pending'; // Секогаш постави 'pending'

    try {
        $sql = "INSERT INTO campaigns (Name, Description, StartDate, EndDate, TargetAmount, OrganizerID, Status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdis", $Name, $Description, $StartDate, $EndDate, $TargetAmount, $OrganizerID, $Status);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<div class='alert alert-success'>Кампањата е успешно креирана!, кампањата ќе се појави откако администраторот ќе ја одобри, за тоа време пратете му го официјалниот документ на неговиот меил.</div>";
        } else {
            echo "<div class='alert alert-danger'>Грешка при креирање на кампањата.</div>";
        }

        $stmt->close();
        $conn->close();
    } catch (mysqli_sql_exception $e) {
        echo "<div class='alert alert-danger'>Грешка: " . $e->getMessage() . "</div>";
    }
}
?>

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

        <form method="POST" action="">
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
                <input type="number" step="0.01" class="form-control" id="TargetAmount" name="TargetAmount" required>
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
