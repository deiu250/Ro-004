<?php
session_start();
$conn = new mysqli("localhost", "root", "", "19086");


if ($conn->connect_error) {
    die("Eroare la conectare: " . $conn->connect_error);
}

// Obține toate vizitele
$sql = "SELECT * FROM visits ORDER BY visit_time DESC";
$res = $conn->query($sql);
$sezoane = $conn->query("SELECT * FROM sezoane ORDER BY id ASC");

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
// Stergere premiu
if (isset($_GET['delete_premiu'])) {
    $id_premiu = intval($_GET['delete_premiu']);
    $stmt = $conn->prepare("DELETE FROM premii WHERE id = ?");
    $stmt->bind_param("i", $id_premiu);
    $stmt->execute();
    $stmt->close();

    // Redirect ca să nu revină la ștergerea asta dacă dai refresh
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
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
<details><summary>📊 Statistici Vizite</summary>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pagină</th>
                <th>Adresa IP</th>
                <th>Data și ora</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($res->num_rows > 0): ?>
                <?php while($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['page']) ?></td>
                        <td><?= $row['ip_address'] ?></td>
                        <td><?= $row['visit_time'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">Nu există vizite înregistrate.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</details>
                
        
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

    <details><summary>Lista Membrilor</summary>
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
    <div style='
        border: 1px solid #ccc; 
        padding: 10px; 
        width: 250px; 
        align-items: center; 
        position: relative; 
        justify-content: center; 
        display: flex; 
        text-align: center;
        flex-direction: column; 
        margin: 10px;
        border-radius: 10px;
    '>
        <img src='" . htmlspecialchars($row['logo']) . "' 
             alt='" . htmlspecialchars($row['nume']) . "' 
             style='width: 60%; height: auto; margin-bottom: 10px;'>
             
        <h3>" . htmlspecialchars($row['nume']) . "</h3>
        
        <p><a href='" . htmlspecialchars($row['link']) . "' target='_blank'>Website</a></p>
        
        <p>" . nl2br(htmlspecialchars($row['descriere'])) . "</p>
        
        <a href='?delete_sponsor=" . urlencode($row['id']) . "' 
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

        const savedTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyMode(savedTheme);
    </script>
   
   <form action="code/adauga_sezon_submit.php" method="POST">
    <label>Nume sezon:</label>
    <input type="text" name="nume" required>
    <button type="submit">Adaugă sezon</button>
</form>

   <form action="code/adauga_premiu_submit.php" method="POST" enctype="multipart/form-data">
    <label>Sezon:</label>
    <select name="sezon_id" required>
        <?php while ($sezon = $sezoane->fetch_assoc()): ?>
            <option value="<?= $sezon['id'] ?>"><?= htmlspecialchars($sezon['nume']) ?></option>
        <?php endwhile; ?>
    </select>

    <label>Nume premiu:</label>
    <input type="text" name="nume_premiu" required>

    <label>Etapă:</label>
    <select name="etapa" required>
        <option value="Regională">Regională</option>
        <option value="Națională">Națională</option>
    </select>

    <label>Poziție:</label>
    <select name="pozitie">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>

    <label>Descriere:</label>
    <textarea name="descriere" required></textarea>

    <label>Imagine premiu:</label>
    <input type="file" name="poza" required>

    <button type="submit">Adaugă premiu</button>
       <?php
$query = "SELECT * FROM premii ORDER BY id DESC";
$rezultat = $conn->query($query);

while ($premiu = $rezultat->fetch_assoc()):
?>
    <details><summary>Lista premii</summary>
        <div class="award">
        <p><?= htmlspecialchars($premiu['nume_premiu']) ?> - Etapa <?= htmlspecialchars($premiu['etapa']) ?></p>
        <div class="award-img-container">
            <img style="width: 50%; height: auto;" src="code/uploadspremii/<?= htmlspecialchars($premiu['poza']) ?>" alt="<?= htmlspecialchars($premiu['nume_premiu']) ?>">
        </div>
        <a href="?delete_premiu=<?= $premiu['id'] ?>"
           onclick="return confirm('Sigur vrei să ștergi premiul <?= htmlspecialchars($premiu['nume_premiu']) ?>?')"
           style="color: red; text-decoration: none;">🗑️ Șterge</a>
    </div></details>
<?php endwhile; ?>

</form>
</body>
</html>
