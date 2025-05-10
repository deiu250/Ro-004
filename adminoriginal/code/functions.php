<?php
session_start();
header('Cache-Control: private, no-store');

function connection($host, $user, $passw, $db) {
    global $conn;
    $conn = mysqli_connect($host, $user, $passw, $db) or
        die("Could not connect: " . mysqli_connect_error());
}

function authorization($user, $passw) {
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $rez = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($rez)) {
        $hashed_pass = $row['password'];
        if (password_verify($passw, $hashed_pass)) {
            $_SESSION['user'] = $user;
            $_SESSION['id'] = session_id();
            return true;
        }
    }
    return false;
}


function authentification() {
    global $conn;

    if(!isset($_SESSION['user'], $_SESSION['passw'], $_SESSION['id']) || $_SESSION['id'] !== session_id()) {
        return false;
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $_SESSION['user'], $_SESSION['passw']);
    mysqli_stmt_execute($stmt);
    $rez = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($rez) === 1;
}

//daca nu merge da ctrl-z ;