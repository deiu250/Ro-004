<?php
include 'config.php';
$conn = new mysqli("localhost", "root", "", "19086");


$nume = $_POST['nume'];
$stmt = $conn->prepare("INSERT INTO sezoane (nume) VALUES (?)");
$stmt->bind_param("s", $nume);
$stmt->execute();

header("Location: ../index.php?pagina=adauga_sezon&status=success");