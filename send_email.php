<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Вземете ги податоците од формата
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // Проверка за валидност на е-поштата
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Внесете валидна е-пошта.";
        exit;
    }

    // Поставете ја е-поштата на која ќе се испрати пораката
    $to = "jovanovskinenad1@gmail.com"; // Заменете ја оваа адреса со вашата
    $subject = "Нова порака од " . $name;

    // Составете ја содржината на пораката
    $messageContent = "Име: " . $name . "\n";
    $messageContent .= "Е-пошта: " . $email . "\n\n";
    $messageContent .= "Порака:\n" . $message;

    // Поставување на хедерите на е-поштата
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8" . "\r\n";
    $headers .= "From: " . $email . "\r\n"; // Поставете го од каде е испратена пораката
    $headers .= "Reply-To: " . $email . "\r\n"; // Поставете ја е-поштата за одговор

    // Испратете ја пораката
    if (mail($to, $subject, $messageContent, $headers)) {
        echo "Пораката беше успешно испратена!";
    } else {
        echo "Грешка при испраќање на пораката.";
    }
}
?>
