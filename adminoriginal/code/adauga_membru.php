<?php
require 'config.php';

$nume = $_POST['nume'] ?? '';
$rol = $_POST['rol'] ?? '';
$poza = $_POST['poza'] ?? '';

if ($nume && $rol && filter_var($poza, FILTER_VALIDATE_URL)) {
  $stmt = $conn->prepare("INSERT INTO membri (nume, rol, poza) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $nume, $rol, $poza);
  $stmt->execute();
  echo "Membru adăugat cu succes!";
} else {
  echo "Date invalide!";
}
?>
