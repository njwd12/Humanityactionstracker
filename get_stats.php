<?php
require_once('db_connection.php');  // Креирај врска со базата

// SQL за статистики
$sql = "
    SELECT 
        (SELECT COUNT(*) FROM campaigns) AS total_campaigns,
        (SELECT COUNT(*) FROM users) AS total_users,
        (SELECT SUM(amount) FROM donations) AS total_donations
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data); // Испраќање податоци како JSON
} else {
    echo json_encode(["total_campaigns" => 0, "total_users" => 0, "total_donations" => 0]);
}

?>
