<?php
session_start();
$conn = new mysqli("localhost", "root", "", "19086");

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['status'] = "Trebuie să fii autentificat pentru a accesa această pagină";
    header("Location: login.php");
    exit();
}

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
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Admin Membri</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>

    <button id="darkModeToggle">🌙 Dark Mode</button>
    
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
    <h2>Adaugă Sponsor</h2>
    <form action="code/adauga_sponsor.php" method="POST" enctype="multipart/form-data">
        <label>Nume Sponsor:</label>
        <input type="text" name="nume" required><br>
        
        <label>Link (website):</label>
        <input type="url" name="link"><br>
        
        <label>Descriere:</label><br>
        <textarea name="descriere" rows="4" cols="50"></textarea><br>
        
        <label>Logo (Imagine):</label>
        <input type="file" name="logo" accept="image/*" required><br>
        
        <button type="submit">Adaugă Sponsor</button>
    </form>
    <form action="logout.php" method="post">
    <button type="submit">Logout</button>
    </form>
    
    <script>
        const toggle = document.getElementById('darkModeToggle');
        const body = document.body;
        
        function applyMode(mode) {
            if (mode === 'dark') {
                body.classList.add('dark');
                toggle.textContent = '☀️ Light Mode';
            } else {
                body.classList.remove('dark');
                toggle.textContent = '🌙 Dark Mode';
            }
        }
        
        toggle.addEventListener('click', () => {
            const isDark = body.classList.contains('dark');
            const newMode = isDark ? 'light' : 'dark';
            localStorage.setItem('theme', newMode);
            applyMode(newMode);
        });
        
        // Load theme on page load
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyMode(savedTheme);
        </script>

</body>
</html>

