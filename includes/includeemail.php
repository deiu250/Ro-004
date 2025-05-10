<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['nume']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['mesaj']));

    if (!$email) {
        exit("Email invalid!");
    }

    $mail = new PHPMailer(true);

    try {
        // Configurare SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'andrei.mihali@lucaciu.ro'; // înlocuiește cu adresa ta
        $mail->Password   = 'yourapppassword';     // App Password, nu parola normală
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Setări email
        $mail->setFrom($email, $name);
        $mail->addAddress('ydcl0ddh7@mozmail.com');
        $mail->Subject = "Propunere de sponsorizare de la $name";
        $mail->Body    = $message;

        $mail->send();
        header("Location: sponsori.php");
        exit();
    } catch (Exception $e) {
        exit("Eroare la trimiterea emailului: {$mail->ErrorInfo}");
    }
} else {
    exit("Acces interzis!");
}
