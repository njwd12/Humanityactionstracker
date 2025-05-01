<?php
require_once 'db_connection.php';

// Ensure user is logged in (if you have session management, this is crucial)
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to donate.";
    exit;
}

// Get Donor ID from session or any other method you're using
$donorID = $_SESSION['user_id'];

// Process donation on form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $campaignID = $_POST['campaignID'];
    $amount = $_POST['amount'];
    $donationDate = date("Y-m-d H:i:s");  // Current timestamp

    // Validate donation amount (simple check for positive value)
    if ($amount <= 0) {
        echo "Donation amount must be greater than zero.";
        exit;
    }

    // Insert the donation into the database
    $query = "INSERT INTO donations (CampaignID, DonorID, Amount, DonationDate) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iids", $campaignID, $donorID, $amount, $donationDate);

    if ($stmt->execute()) {
        echo "Thank you for your donation!";
        
        // Optionally, update the campaign (e.g., reduce remaining amount or add donor)
        // Update registered users or campaign target
        $update_query = "UPDATE campaigns SET registered_users = registered_users + 1 WHERE CampaignID = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("i", $campaignID);
        $update_stmt->execute();
    } else {
        echo "Error processing the donation. Please try again later.";
    }

    // Redirect or display a confirmation message after successful donation
    header("Location: campaign-read.php"); // Redirect to campaign list or similar page
    exit;
}

// Get campaign ID from the URL or default to 1 if none
$campaignID = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : 1;

// Fetch campaign details from the database
$query = "SELECT * FROM campaigns WHERE CampaignID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $campaignID);
$stmt->execute();
$result = $stmt->get_result();
$campaign = $result->fetch_assoc();

if (!$campaign) {
    echo "Campaign not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to Campaign</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-top: 10px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Donate to Campaign: <?= htmlspecialchars($campaign['Name']) ?></h1>
    <p><?= nl2br(htmlspecialchars($campaign['Description'])) ?></p>
    <p><strong>Посакувана вредност:</strong> <?= number_format($campaign['TargetAmount'], 2) ?></p>
    <p><strong>Почетна дата:</strong> <?= $campaign['StartDate'] ?></p>
    <p><strong>Крајна дата:</strong> <?= $campaign['EndDate'] ?></p>

    <form action="donate.php" method="POST">
        <input type="hidden" name="campaignID" value="<?= $campaignID ?>">
        <label for="donorID">Your Donor ID:</label>
        <input type="number" id="donorID" name="donorID" value="<?= $donorID ?>" readonly required>
    
        
        <button type="button" onclick="window.location.href='payment.php?campaignID=<?= $campaignID ?>'">Донирај</button>

    </form>
</body>
</html>
