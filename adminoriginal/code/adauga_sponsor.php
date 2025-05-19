<?php
$mysqli = new mysqli("localhost", "root", "", "19086");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nume = $mysqli->real_escape_string($_POST["nume"]);
    $link = $mysqli->real_escape_string($_POST["link"]);
    $descriere = $mysqli->real_escape_string($_POST["descriere"]);

    // Upload imagine
    $logo_name = $_FILES["logo"]["name"];
    $logo_tmp = $_FILES["logo"]["tmp_name"];
    $logo_path = "uploads/" . basename($logo_name);

    if (move_uploaded_file($logo_tmp, $logo_path)) {
        $stmt = $mysqli->prepare("INSERT INTO sponsori (nume, link, logo, descriere) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nume, $link, $logo_path, $descriere);
        $stmt->execute();

        echo "✅ Sponsor adăugat cu succes!";
    } else {
        echo "❌ Eroare la upload imagine.";
    }
}
?>