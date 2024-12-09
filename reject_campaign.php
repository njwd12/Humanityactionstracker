<?php
// Врска со базата на податоци
include 'db_connection.php';

// Ако е испратен ID на кампања за одбивање
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL за ажурирање на статусот на кампањата
    $sql = "UPDATE campaigns SET status='rejected' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Кампањата е одбиена!";
        header("Location: admin_dashboard.php");
    } else {
        echo "Грешка при одбивање на кампањата: " . $conn->error;
    }
}
?>
