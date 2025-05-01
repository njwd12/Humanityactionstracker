<?php
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "hatracker";

// Create connection
$conn= new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);  // Log to file
    die("Connection failed: " . $conn->connect_error);
}
?>
