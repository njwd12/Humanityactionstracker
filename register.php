<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // ako koristis composer za PHPMailer

include 'db_connection.php';

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $verification_token = bin2hex(random_bytes(16)); // 32-character token

    // Check if email exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Email is already registered";
        $toastClass = "bg-warning";
    } else {
        // Insert new user with token and not verified
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_verified, verification_token) VALUES (?, ?, ?, 0, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $verification_token);
        if ($stmt->execute()) {

            // Send verification email
            $verify_link = "http://localhost:8080/crud_app/cruddiy/core/app/verify.php?token=$verification_token";
                // promeni ako hostiras online

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'jovanovskinenad1@gmail.com'; // SMTP email
                $mail->Password = 'amsllgmkopzmuraz'; // App password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('jovanovskinenad1@gmail.com', 'Регистрација');
                $mail->addAddress($email, $username);

                $mail->isHTML(true);
                $mail->Subject = 'Верификација на email';
                $mail->Body = "Здраво $username,<br><br>Кликни на линкот за да го верифицираш твојот email:<br><a href='$verify_link'>$verify_link</a>";

                $mail->send();
                $message = "Регистрација успешна. Провери email за верификација.";
                $toastClass = "bg-success";
            } catch (Exception $e) {
                $message = "Регистрација не успеа при праќање на email: " . $mail->ErrorInfo;
                $toastClass = "bg-danger";
            }
        } else {
            $message = "Грешка при регистрација.";
            $toastClass = "bg-danger";
        }
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Register</title>
    <style>
        body {
            background: linear-gradient(to right, #f6d365, #fda085);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 400px;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-success {
            background-color: #4caf50;
            border: none;
            width: 100%;
        }
        .btn-success:hover {
            background-color: #388e3c;
        }
        .form-label {
            font-weight: bold;
            color: #fff;
        }
        .form-text {
            color: #ddd;
        }
        .text-link {
            color: #ffd700;
            text-decoration: none;
        }
        .text-link:hover {
            text-decoration: underline;
        }
        .toast {
            width: 100%;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <?php if ($message): ?>
            <div class="toast align-items-center text-white <?php echo $toastClass; ?>" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="form-control mt-5 p-4">
            <div class="row">
                <h5 class="text-center p-4" style="font-weight: 700; color: #388e3c;">Create Account</h5>
            </div>
            <div class="col mb-3">
                <label for="username" class="form-label"  style="color: green;">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="col mb-3">
                <label for="email" class="form-label" style="color: green;">Email</label>
                <input type="text" name="email" id="email" class="form-control" required>
            </div>
            <div class="col mb-3">
                <label for="password" class="form-label" style="color: green;">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="col mb-3">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
            <div class="col mb-2 mt-4">
                <p class="text-center">
                    <a href="./login.php" class="text-link">Already have an account? Login</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>
