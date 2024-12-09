<?php
require_once('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $CampaignID = $_POST['CampaignID'] ?? null;
    
    if ($CampaignID) {
        // Одобрување на кампањата
        $stmt = $conn->prepare("UPDATE campaigns SET Status = 'approved' WHERE CampaignID = ?");
        $stmt->execute([$CampaignID]);
        
        // Пренасочување назад на админ таблата
        header("Location: admin_dashboard.php");
        exit();
    }
}
?>
