<?php
session_start();
include 'db_connection.php';

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "All fields are required.";
        $toastClass = "alert-danger";
    } else {
        $stmt = $conn->prepare("SELECT UserID, username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $username_db, $db_password, $role);
            $stmt->fetch();

            if (password_verify($password, $db_password)) {
                $_SESSION['username'] = $username_db;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['role'] = $role;

                header("Location: " . ($role === 'Admin' ? "admin_dashboard.php" : "dashboard.php"));
                exit();
            } else {
                $message = "Incorrect password.";
                $toastClass = "alert-danger";
            }
        } else {
            $message = "Email not found.";
            $toastClass = "alert-warning";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(to right, #4facfe, #00f2fe);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: rgba(0.15, 0.15, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #4c51bf;
            border: none;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #434190;
        }
        .form-label {
            font-weight: bold;
            color: #fff;
        }
        .form-text {
            color: #ddd;
        }
        a {
            color: #ffd700;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="text-center text-white mb-4">Login to Your Account</h3>
        <?php if ($message): ?>
            <div class="alert <?php echo $toastClass; ?> text-white text-center">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <div class="text-center mt-3">
                <p class="form-text">
                    <a href="./register.php">Create an Account</a> | <a href="./resetpassword.php">Forgot Password?</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
