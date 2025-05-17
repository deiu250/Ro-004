<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// 1. Conectare la baza de date
$conn = new mysqli("localhost", "root", "", "19086");
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// 2. Procesare formular
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['nume']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['mesaj']));
    $amount = htmlspecialchars(trim($_POST['suma']));

    if (!$email) {
        exit("Email invalid!");
    }

    // 3. Salvare în baza de date
    $stmt = $conn->prepare("INSERT INTO sponsorizari (nume, email, mesaj, suma) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssd", $name, $email, $message, $amount);
    $stmt->execute();
    $stmt->close();

    // 4. Trimitere email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'deiumihali0@gmail.com';
        $mail->Password   = 'krmh ceqd arpu qnfz'; // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('deiumihali0@gmail.com', 'Formular Sponsorizare');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('deiumihali0@gmail.com');
        $mail->Subject = "Propunere de sponsorizare de la $name";
        $mail->Body = "Mesaj de la $name\nEmail: $email\n\nMesaj:\n$message\n\nSuma propusă: $amount lei";

        $mail->send();
        header("Location: http://localhost/Ro-004/sponsori.php");
        exit();
    } catch (Exception $e) {
        exit("Eroare la trimiterea emailului: {$mail->ErrorInfo}");
    }
} else {
    exit("Acces interzis!");
}
?>
