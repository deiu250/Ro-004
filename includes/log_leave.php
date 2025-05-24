<?php
// Conectare DB
$conn = new mysqli("localhost", "root", "", "19086");
if ($conn->connect_error) exit;

// Obține pagina și IP-ul
$page = $_POST['page'];
$ip = $_SERVER['REMOTE_ADDR'];

// Actualizează ultimul log corespunzător IP-ului și paginii
$sql = "UPDATE visits 
        SET leave_time = NOW() 
        WHERE page = ? AND ip_address = ? AND leave_time IS NULL 
        ORDER BY visit_time DESC 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $page, $ip);
$stmt->execute();

$stmt->close();
$conn->close();

