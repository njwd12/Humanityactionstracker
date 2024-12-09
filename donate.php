<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];
$query = "SELECT UserID FROM Users WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$donorID = $user['UserID'];
$campaignID = $_POST['campaign_id'];
$amount = $_POST['amount'];

// Insert the donation into the database
$query = "INSERT INTO Donations (CampaignID, DonorID, Amount) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $campaignID, $donorID, $amount);

if ($stmt->execute()) {
    echo "<p>Donation successful! Thank you for your contribution.</p>";
} else {
    echo "<p>Error processing donation. Please try again.</p>";
}

$stmt->close();
$conn->close();
?>
<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$userEmail = $_SESSION['email'];
$query = "SELECT UserID FROM Users WHERE Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$donorID = $user['UserID'];
$campaignID = $_POST['campaign_id'];
$amount = $_POST['amount'];

// Insert the donation into the database
$query = "INSERT INTO Donations (CampaignID, DonorID, Amount) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $campaignID, $donorID, $amount);

if ($stmt->execute()) {
    echo "<p>Donation successful! Thank you for your contribution.</p>";
} else {
    echo "<p>Error processing donation. Please try again.</p>";
}

$stmt->close();
$conn->close();
?>
