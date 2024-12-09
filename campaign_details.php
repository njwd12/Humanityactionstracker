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

$userID = $user['UserID'];
$role = $user['Role'];

$campaignID = $_GET['id'];
$query = "SELECT * FROM Campaigns WHERE CampaignID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $campaignID);
$stmt->execute();
$campaign = $stmt->get_result()->fetch_assoc();

// Fetch beneficiaries for this campaign
$query = "SELECT * FROM Beneficiaries b INNER JOIN CampaignBeneficiaries cb ON b.BeneficiaryID = cb.BeneficiaryID WHERE cb.CampaignID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $campaignID);
$stmt->execute();
$beneficiaries = $stmt->get_result();

// Fetch donations for this campaign
$query = "SELECT SUM(Amount) AS total_donations FROM Donations WHERE CampaignID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $campaignID);
$stmt->execute();
$totalDonationsResult = $stmt->get_result();
$totalDonations = $totalDonationsResult->fetch_assoc()['total_donations'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h1><?php echo $campaign['Name']; ?></h1>
    <p><?php echo $campaign['Description']; ?></p>
    <p><strong>Target Amount:</strong> $<?php echo $campaign['TargetAmount']; ?></p>
    <p><strong>Amount Raised:</strong> $<?php echo $totalDonations ? $totalDonations : 0; ?></p>

    <h3>Beneficiaries</h3>
    <ul>
        <?php while ($beneficiary = $beneficiaries->fetch_assoc()): ?>
            <li><?php echo $beneficiary['FullName']; ?> - <?php echo $beneficiary['Description']; ?></li>
        <?php endwhile; ?>
    </ul>

    <?php if ($role == 'Donor'): ?>
        <h3>Make a Donation</h3>
        <form action="donate.php" method="POST">
            <input type="hidden" name="campaign_id" value="<?php echo $campaignID; ?>">
            <div class="mb-3">
                <label for="amount" class="form-label">Donation Amount</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Donate</button>
        </form>
    <?php endif; ?>

    <?php if ($role == 'Organizer' || $role == 'Admin'): ?>
        <a href="organize_campaign.php" class="btn btn-primary mt-3">Organize New Campaign</a>
    <?php endif; ?>
</div>

</body>
</html>
