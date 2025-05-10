<?php
session_start();
$conn = new mysqli("localhost", "root", "", "19086");

if ($conn->connect_error) {
    die("Eroare conexiune: " . $conn->connect_error);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user_login = trim($_POST['username']);
    $user_password = $_POST['password'];

    if (empty($user_login) || empty($user_password)) {
        $_SESSION['status'] = "Toate câmpurile sunt obligatorii";
        header("Location: login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $user_login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user_data = $result->fetch_assoc()) {
        if (password_verify($user_password, $user_data['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user_login;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['status'] = "Parolă incorectă";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['status'] = "Utilizatorul nu există";
        header("Location: login.php");
        exit();
    }
}
?>
