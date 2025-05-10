<?php
session_start();
$conn = new mysqli("localhost", "root", "", "19086");



// Ștergere membru
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $res = $conn->query("SELECT poza FROM membri WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        if (file_exists($row['poza'])) {
            unlink($row['poza']);
        }
    }
    $conn->query("DELETE FROM membri WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Adăugare membru
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nume = $_POST["nume"];
    $rol = $_POST["rol"];
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $ext = pathinfo($_FILES["poza"]["name"], PATHINFO_EXTENSION);
    $poza_nume = uniqid() . "." . $ext;
    $target_file = $target_dir . $poza_nume;

    if (move_uploaded_file($_FILES["poza"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO membri (nume, rol, poza) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nume, $rol, $target_file);
        $stmt->execute();
        header("Location: index.php");
        exit();
    } else {
        echo "<p style='color:red;'>Eroare la upload imagine.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Membri</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background: #f7f7f7;
        }
        form {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 400px;
            margin-bottom: 2rem;
        }
        input, button {
            width: 100%;
            padding: 0.6rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        .card {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 1rem;
        }
        .card-info {
            flex-grow: 1;
        }
        .card a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Adaugă Membru Nou</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nume:</label>
        <input type="text" name="nume" required>

        <label>Rol:</label>
        <input type="text" name="rol" required>

        <label>Poza:</label>
        <input type="file" name="poza" accept="image/*" required>

        <button type="submit">Adaugă membru</button>
    </form>

    <h2>Lista Membrilor</h2>
    <?php
    $res = $conn->query("SELECT * FROM membri ORDER BY id DESC");
    while ($row = $res->fetch_assoc()) {
        echo '<div class="card">';
        echo '<img src="' . $row['poza'] . '" alt="poza">';
        echo '<div class="card-info">';
        echo '<h3>' . htmlspecialchars($row['nume']) . '</h3>';
        echo '<p>Rol: ' . htmlspecialchars($row['rol']) . '</p>';
        echo '</div>';
        echo '<a href="?delete=' . $row['id'] . '" onclick="return confirm(\'Sigur vrei să ștergi?\')">Șterge</a>';
        echo '</div>';
    }
    ?>
</body>
</html>
