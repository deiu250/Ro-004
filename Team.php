<!DOCTYPE html>
<html>

<head>
    <title>ROBOCORNS</title>
    <link rel="icon" type="image/jpeg" href="css/inuse/logo _png.png">
    <link rel="stylesheet" href="css/team.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

<body>
    <?php include_once ("includes/navbar.php")?>
    <header>
        Echipa
    </header>
    <?php
$conn = new mysqli("localhost", "root", "", "19086");

// Define categorii (subtitluri)
$categorii = [
    "Mentor" => ["mentor"],
    "CAD" => ["Team Leader", "CAD Designer", "Mechanic"],
    "Programare" => ["Teleop leader", "TeleOp", "Auto leader", "Auto"],
    "Scouting" => ["Scout Leader", "Scouter"],
    "Public-Relations" => ["PR Leader", "Sponsor finder", "Main designer"],
];

foreach ($categorii as $titlu => $keywords) {
    echo "<p>$titlu</p>";
    echo "<div class='container$titlu' style='justify-content: space-evenly; display: flex; flex-wrap: wrap;'>";

    $result = $conn->query("SELECT * FROM membri");
    while ($row = $result->fetch_assoc()) {
        foreach ($keywords as $kw) {
            if (stripos($row['rol'], $kw) !== false) {
                echo "<div class='member-content'>";
                echo "<img src='adminoriginal/" . $row['poza'] . "' alt=''>";
                echo "<h1>" . htmlspecialchars($row['nume']) . "</h1>";
                echo "<div class='member-info'>";
                echo "<p>Rol: " . htmlspecialchars($row['rol']) . "</p>";
                // aici poți adăuga și alte info dacă le ai, gen clasa
                echo "</div></div>";
                break;
            }
        }
    }

    echo "</div>";
}
include_once ("includes/footer.php");
?>

</body>

</html>