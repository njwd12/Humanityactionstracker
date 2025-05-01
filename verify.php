<?php
include 'db_connection.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT UserID FROM users WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Verify the email
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        $update = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE UserID = ?");
        $update->bind_param("i", $user_id);
        
        if ($update->execute()) {
            $message = "Email is successfully verified. You can now login.";
        } else {
            $message = "Error verifying email.";
        }
        $update->close();
    } else {
        $message = "Invalid or already used token.";
    }

    $conn->close();
} else {
    $message = "Missing token.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Email Verification</title>
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .verification-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 500px;
            text-align: center;
        }
        .btn-primary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <h3 class="mb-4">Email Verification</h3>
        <p><?php echo $message; ?></p>
        <?php if (strpos($message, 'successfully') !== false): ?>
            <a href="login.php" class="btn btn-primary">Go to Login</a>
        <?php endif; ?>
    </div>
</body>
</html>