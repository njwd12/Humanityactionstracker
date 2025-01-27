<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Вклучи PHPMailer ако користиш Composer

session_start(); // Започни сесија

// Проверка дали корисникот е најавен
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    echo "<script>alert('Мора да бидете најавени за да испратите порака.');</script>";
    exit();
}

$logged_in_email = $_SESSION['email']; // Емаил на најавениот корисник

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Проверка дали внесениот email е исти како на најавениот корисник
    if ($email !== $logged_in_email) {
        echo "<script>alert('Не можете да испратите порака од друг email.');</script>";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        //Конфигурација на SMTP сервер
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Може да го промениш на твојот SMTP сервер
        $mail->SMTPAuth = true;
        $mail->Username = 'jovanovskinenad1@gmail.com'; // Твојот email за SMTP
        $mail->Password = 'amsllgmkopzmuraz';  // Твојата лозинка или апликациски лозинка
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Поставување на кодирање на каректерите
        $mail->CharSet = 'UTF-8'; // Ова е важно за правилно кодирање на пораката

        // Постави од кого е пораката
        $mail->setFrom($email, $name);  
        $mail->addAddress('jovanovskinenad1@gmail.com');  // Кому ќе оди пораката

        // Постави содржина на email
        $mail->isHTML(false); // Не користиме HTML за оваа порака
        $mail->Subject = 'Нова порака од ' . $name;
        $mail->Body = "Име: " . $name . "\n" .
                      "Email: " . $email . "\n\n" .
                      "Порака:\n" . $message;

        // Испрати email
        $mail->send();
        echo "<script>alert('Пораката е испратена успешно!');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Грешка при испраќањето на пораката: {$mail->ErrorInfo}');</script>";
    }
}
?>
