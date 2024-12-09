<?php
require_once 'db_connection.php';

// Fetch all donations
function getDonations($conn) {
    $query = "SELECT * FROM donations";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

// Add a donation
function addDonation($conn, $userId, $campaignId, $amount) {
    $query = "INSERT INTO donations (user_id, campaign_id, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iid", $userId, $campaignId, $amount);
    return $stmt->execute();
}

// Get total donations for a specific campaign
function getTotalDonations($conn, $campaignId) {
    $query = "SELECT SUM(amount) as total FROM donations WHERE campaign_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $campaignId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data['total'] ?? 0;
}
?>
