<?php
require_once('db_connection.php');
session_start();

// Check if the campaign ID is set
if (isset($_POST['CampaignID'])) {
    $campaignID = $_POST['CampaignID'];
    
    // Update the campaign status to "rejected"
    $stmt = $conn->prepare("UPDATE campaigns SET Status = 'rejected' WHERE CampaignID = ?");
    if ($stmt->execute([$campaignID])) {
        // Redirect to the dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Handle error if update fails
        echo "Грешка при отфрлање на кампањата.";
    }
}
?>
