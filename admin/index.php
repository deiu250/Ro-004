<?php
session_start();
$conn = new mysqli("localhost", "root", "", "19086");

// Verificare autentificare
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['status'] = "Trebuie să fii autentificat pentru a accesa această pagină";
    header("Location: login.php");
    exit();
}

// Ștergere membru
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $res = $conn->query("SELECT poza FROM membri WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        if (file_exists($row['poza'])) {
            unlink($row['poza']);
        }
    }
    $conn->query("DELETE FROM membri WHERE id = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
// Ștergere sponsor
if (isset($_GET['delete_sponsor'])) {
    $id = intval($_GET['delete_sponsor']);
    $res = $conn->query("SELECT logo FROM sponsori WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        if (file_exists($row['logo'])) {
            unlink($row['logo']);
        }
    }
    $conn->query("DELETE FROM sponsori WHERE id = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Adăugare membru
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_member'])) {
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
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p style='color:red;'>Eroare la upload imagine.</p>";
    }
}

// Adăugare sponsor
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_sponsor'])) {
    $nume = $conn->real_escape_string($_POST["nume"]);
    $link = $conn->real_escape_string($_POST["link"]);
    $descriere = $conn->real_escape_string($_POST["descriere"]);

    $logo_name = $_FILES["logo"]["name"];
    $logo_tmp = $_FILES["logo"]["tmp_name"];
    $logo_path = "code/uploadssponsori/" . basename($logo_name);
    
    if (move_uploaded_file($logo_tmp, $logo_path)) {
        $stmt = $conn->prepare("INSERT INTO sponsori (nume, link, logo, descriere) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nume, $link, $logo_path, $descriere);
        $stmt->execute();
        echo "<p style='color:green;'>✅ Sponsor adăugat cu succes!</p>";
    } else {
        echo "<p style='color:red;'>❌ Eroare la upload imagine.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
    <head>
        <meta charset="UTF-8">
        <title>Admin Dashboard</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css.css">
    </head>
    <body>
        <div style="display: flex; justify-content: space-between;">
            <button id="darkModeToggle">🌙 Dark Mode</button>
            <button onclick="logout()" style="cursor: pointer; padding: 2px 16px; border: none; width: auto;">Logout</button>
        </div>

<script>
function logout() {
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "logout.php";

    document.body.appendChild(form);
    form.submit();
}
</script>
        
        <h2>Adaugă Membru Nou</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="add_member" value="1">
        <label>Nume:</label>
        <input type="text" name="nume" required>
        
        <label>Rol:</label>
        <input type="text" name="rol" required>
        
        <label>Poza:</label>
        <input type="file" name="poza" accept="image/*" required>

        <button type="submit">Adaugă membru</button>
    </form>

    <details><summary>📋 Lista Membrilor</summary>
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
    </details>

    <h2>Adaugă Sponsor</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="add_sponsor" value="1">
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


    <details><summary>Lista Sponsori</summary>

    <?php
    $result = $conn->query("SELECT * FROM sponsori ORDER BY id DESC");
    while ($row = $result->fetch_assoc()) {
    echo "
    <div style=''
    border: 1px solid #ccc; 
    padding: 10px; 
    width: 250px; 
    align-items: center; 
    position: relative; 
    justify-content: center; 
    display: flex; 
    text-align: center;
    flex-direction: column; 
''>
        <img src='{$row['logo']}' alt='{$row['nume']}' style='width: 20%; height: auto;'>
        <h3>{$row['nume']}</h3>
        <p><a href='{$row['link']}' target='_blank'>Website</a></p>
        <p>{$row['descriere']}</p>
        <a href='?delete_sponsor={$row['id']}' 
           onclick='return confirm(\"Sigur vrei să ștergi sponsorul?\")'
           style='color: red; position: absolute; top: 10px; right: 10px; text-decoration: none;'>🗑️</a>
    </div>
    ";
}
?>

</details>


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

        const savedTheme = localStorage.getItem('theme') || 'light';
        applyMode(savedTheme);
    </script>
</body>
</html>
