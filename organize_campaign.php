<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];
$query = "SELECT UserID, Role FROM Users WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$role = $user['Role'];

if ($role != 'Organizer') {
    echo "You don't have permission to organize campaigns.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $targetAmount = $_POST['target_amount'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $query = "INSERT INTO Campaigns (Name, Description, StartDate, EndDate, TargetAmount, OrganizerID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssdi", $name, $description, $startDate, $endDate, $targetAmount, $user['UserID']);

    if ($stmt->execute()) {
        echo "<p>Campaign created successfully!</p>";
    } else {
        echo "<p>Error creating campaign. Please try again.</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organize Campaign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1>Organize a New Campaign</h1>
    <form action="organize_campaign.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Campaign Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="target_amount" class="form-label">Target Amount</label>
            <input type="number" name="target_amount" id="target_amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Create Campaign</button>
    </form>
</div>

</body>
</html>
