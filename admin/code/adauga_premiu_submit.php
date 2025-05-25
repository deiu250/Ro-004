<?php
session_start();

$conn = new mysqli("localhost", "root", "", "19086");

// Verificare conexiune DB
if ($conn->connect_error) {
    die("Conexiune eșuată: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validare input
    $sezon_id = $_POST['sezon_id'] ?? null;
    $nume_premiu = $_POST['nume_premiu'] ?? '';
    $etapa = $_POST['etapa'] ?? '';
    $pozitie = $_POST['pozitie'] ?? '';
    $descriere = $_POST['descriere'] ?? '';

    // Validare sezon_id
    if (!$sezon_id || !is_numeric($sezon_id)) {
        die("Sezon ID invalid!");
    }

    // Procesare imagine
    $target_dir = "uploadspremii/";
    $poza = basename($_FILES["poza"]["name"]);
    $target_file = $target_dir . $poza;

    // Verificare dacă folderul e scriabil
    if (!is_writable($target_dir)) {
        die("Folderul $target_dir nu are permisiuni de scriere!");
    }

    // Verificare dacă fișierul este imagine
    $check = getimagesize($_FILES["poza"]["tmp_name"]);
    if ($check === false) {
        die("Fișierul nu este o imagine validă.");
    }

    // Încărcare imagine
    if (!move_uploaded_file($_FILES["poza"]["tmp_name"], $target_file)) {
        die("Eroare la încărcarea imaginii.");
    }

    // Inserare în DB
    $stmt = $conn->prepare("INSERT INTO premii (sezon_id, nume_premiu, etapa, pozitie, descriere, poza) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Eroare la prepare(): " . $conn->error);
    }

    $stmt->bind_param("isssss", $sezon_id, $nume_premiu, $etapa, $pozitie, $descriere, $poza);
    if (!$stmt->execute()) {
        die("Eroare la executare: " . $stmt->error);
    }

    header("Location: ../index.php?pagina=adauga_premiu&status=success");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>
