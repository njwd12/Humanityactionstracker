<?php
require_once('db_connection.php');
session_start(); // Start session to get the logged-in user's ID

// Check if the user is logged in, assuming the session has a 'user_id' key
if (!isset($_SESSION['user_id'])) {
    die("Мора да се најавите.");
}

// Get the logged-in user's ID
$loggedInUserID = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Campaign fields
    $Name = $_POST['Name'] ?? '';
    $Description = $_POST['Description'] ?? '';
    $StartDate = $_POST['StartDate'] ?? '';
    $EndDate = $_POST['EndDate'] ?? null;
    $TargetAmount = $_POST['TargetAmount'] ?? 0;
    $OrganizerID = $_POST['OrganizerID'] ?? null;
    $Status = 'pending'; // Default status

    // Validate if all required fields are filled
    if (!empty($Name) && !empty($Description) && !empty($StartDate) && !empty($TargetAmount) && $OrganizerID !== null) {
        // Check if the OrganizerID matches the logged-in user's ID
        if ($OrganizerID == $loggedInUserID) {
            // Insert the campaign into the database
            $stmt = $conn->prepare("INSERT INTO campaigns (Name, Description, StartDate, EndDate, TargetAmount, OrganizerID, Status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            // Execute SQL statement
            if ($stmt->execute([$Name, $Description, $StartDate, $EndDate, $TargetAmount, $OrganizerID, $Status])) {
                // Redirect to a page informing the user that the campaign is pending
                header("Location: campaign_pending.php");
                exit();
            } else {
                // Error if the campaign insertion fails
                $error = "Грешка при додавање на настан.";
            }
        } else {
            // Error if the OrganizerID does not match the logged-in user's ID
            $error = "Не можете да креирате кампања со ID на друг организатор.";
        }
    } else {
        // Error if required fields are not filled
        $error = "Пополнете ги сите задолжителни полиња.";
    }
}
?>

<!-- Page for creating a campaign -->
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
