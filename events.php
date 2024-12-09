<?php
require_once 'db_connection.php';

// Fetch all campaigns
function getcampaigns($conn) {
    $query = "SELECT * FROM campaigns ORDER BY event_date ASC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

// Create a new event
function createEvent($conn, $name, $description, $date) {
    $query = "INSERT INTO campaigns (name, description, event_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $description, $date);
    return $stmt->execute();
}

// Register for an event
function registerForEvent($conn, $userId, $eventId) {
    $query = "INSERT INTO event_registrations (user_id, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $eventId);
    return $stmt->execute();
}

// Delete an event
function deleteEvent($conn, $eventId) {
    $query = "DELETE FROM campaigns WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $eventId);
    return $stmt->execute();
}
?>
