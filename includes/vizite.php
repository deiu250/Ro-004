<?php $conn = new mysqli("localhost", "root", "", "19086");

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

// Obține datele vizitei
$page = $_SERVER['PHP_SELF']; // pagina accesată
$ip = $_SERVER['REMOTE_ADDR']; // IP-ul vizitatorului

// Inserează în baza de date
$sql = "INSERT INTO visits (page, ip_address) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $page, $ip);
$stmt->execute();

$stmt->close();
