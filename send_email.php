<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    echo "<script>alert('Мора да бидете најавени за да испратите порака.');</script>";
    exit();
}

$logged_in_email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if ($email !== $logged_in_email) {
        echo "<script>alert('Не можете да испратите порака од друг email.');</script>";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jovanovskinenad1@gmail.com'; // Твој SMTP email
        $mail->Password = 'tukavasalozinka';           // Апликациска лозинка
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8';

        // ВАЖНО: од кого доаѓа (твојата адреса)
        $mail->setFrom('jovanovskinenad1@gmail.com', 'Порака од сајтот');

        // Reply-To: вистинскиот корисник
        $mail->addReplyTo($email, $name);

        // До кого оди пораката
        $mail->addAddress('jovanovskinenad1@gmail.com');

        $mail->isHTML(false);
        $mail->Subject = 'Нова порака од контакт формулар';
        $mail->Body = "Име: " . $name . "\n"
                    . "Email: " . $email . "\n\n"
                    . "Порака:\n" . $message;

        $mail->send();
        echo "<script>alert('Пораката е испратена успешно!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Грешка при испраќање: {$mail->ErrorInfo}');</script>";
    }
}
?>
