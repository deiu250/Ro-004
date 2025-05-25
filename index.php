<?php include_once ("includes/vizite.php");?>
<!DOCTYPE html>
<html>

<head>
    <title>ROBOCORNS</title>
    <link rel="icon" type="image/jpeg" href="includes/logo.jpg">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site oficial al echipei de robotică Robocorns RO004. Află despre proiectele noastre,
    membrii echipei și competițiile la care participăm.">
    <style>
    </style>
</head>

<body>
    <?php include_once("includes/navbar.php")?>

    <header>
        <div>
            Robocorns RO-004
            <p>-break your limits-</p>
        </div>
        
        <div class="wrapper">
        <?php
        $mysqli = new mysqli("localhost", "root", "", "19086");
        if ($mysqli->connect_error) {
            die("Conexiunea a eșuat: " . $mysqli->connect_error);
        }
        
        $result = $mysqli->query("SELECT * FROM sponsori");
        
        $sezoane = $mysqli->query("SELECT * FROM sezoane ORDER BY id ASC");

        $index = 1;
        
        while ($row = $result->fetch_assoc()) {
            $logo = htmlspecialchars($row['logo']);
            $nume = htmlspecialchars($row['descriere']);
            $link= htmlspecialchars($row['link']);
            echo "<a href='$link' target='_blank'>
                    <img style='object-fit: contain;' class='item item$index' src='admin/$logo' alt='$nume'>
                  </a>";

            $index++;
        }
        ?>
        </div>
    </header>
    <section>
    <div class="about-us">
        <div class="container">
            <div class="textcontainer1">
                <div class="Titlu1">Despre noi</div>
                <p>Echipa de robotică Robocorns s-a format în anul 2016, atunci când Nație Prin Educație a adus pentru
                    prima dată concursul în România. De atunci, elevii Colegiului Național “Vasile Lucaciu” Baia Mare au
                    participat la fiecare sezon al competiției First Tech Challange și au depus eforturi imense pentru a
                    obține rezultate impresionante în cadrul competiției. Obiectivul nostru principal este de a
                    introduce
                    robotica la cât mai multe persoane și de a ne dezvolta abilitățile tehnice, cât și cele nontehnice.
                </p>
            </div>
            <div class="slider">
                <div class="slides">
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <input type="radio" name="radio-btn" id="radio3">
                    <input type="radio" name="radio-btn" id="radio4">
                    <input type="radio" name="radio-btn" id="radio5">
                    <input type="radio" name="radio-btn" id="radio6">
                    <input type="radio" name="radio-btn" id="radio7">
                    <input type="radio" name="radio-btn" id="radio8">
                    <input type="radio" name="radio-btn" id="radio9">
                    <input type="radio" name="radio-btn" id="radio10">

                    <div class="slide first">
                        <img src="css/inuse/12.jpeg" alt="">
                        </div>
                    <div class="slide">
                        <img src="css/inuse/14.jpeg" alt="">
                    </div>
                    <div class="slide">
                        <img src="css/inuse/17.jpeg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5367.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5434.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5470.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5484.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5373.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5668.jpg" alt="">
                    </div>
                    <div class="slide">
                        <img src="regionala/Regionala/VK1_5343.jpg" alt="">
                    </div>

                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                        <div class="auto-btn4"></div>
                        <div class="auto-btn5"></div>
                        <div class="auto-btn6"></div>
                        <div class="auto-btn7"></div>
                        <div class="auto-btn8"></div>
                        <div class="auto-btn9"></div>
                        <div class="auto-btn10"></div>
                    </div>
                </div>

                <div class="navigation-manual">
                    <button class="manual-btn prev" onclick="prevSlide()">&#10094;</button>
                    <button class="manual-btn next" onclick="nextSlide()">&#10095;</button>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!--
            <div class="container">
                
                <div class="imagecontainer2">
                    <img src="regionala/Regionala/VK1_5347.jpg" alt="" style="width: 45rem; margin: 10px;">
                </div>
                <div class="textcontainer2">
                    yappayappa
                </div>
            </div>
            <div class="container">
                
                <div class="textcontainer3">
                    yappayappa
                </div>
                <div class="imagecontainer3">
                    <img src="regionala/Regionala/VK1_5347.jpg" alt="" style="width: 45rem; margin: 10px;">
                </div>  
                
            </div>
            -->
    <section>
        <?php



while ($sezon = $sezoane->fetch_assoc()) {
    $sezon_id = $sezon['id'];
    $sezon_nume = htmlspecialchars($sezon['nume']);
    $slug = strtolower(str_replace(' ', '', $sezon_nume)); // ex: Into the Deep -> intothedeep

    echo "<div class='$slug'>";
    echo "<h2>$sezon_nume</h2>";
    echo "<div class='award-container'>";

    $stmt = $conn->prepare("SELECT * FROM premii WHERE sezon_id = ? ORDER BY id ASC");
    $stmt->bind_param("i", $sezon_id);
    $stmt->execute();
    $premii = $stmt->get_result();

    while ($premiu = $premii->fetch_assoc()) {
        $nume = htmlspecialchars($premiu['nume_premiu']);
        $etapa = htmlspecialchars($premiu['etapa']);
        $poza = htmlspecialchars($premiu['poza']);
        $descriere = nl2br(htmlspecialchars($premiu['descriere']));

        echo "
        <div class='award'>
            <p>$nume - Etapa $etapa</p>
            <div class='award-img-container'>
                <img src='admin/code/uploadspremii/$poza' alt='$nume'>
                <div class='award-description'>$descriere</div>
            </div>
        </div>
        ";
    }

    echo "</div></div>";
}
?>
    </section>
</body>
<?php include ("includes/footer.php")?>

</html>
<script>
    window.addEventListener("beforeunload", function () {
      navigator.sendBeacon("log_leave.php", new URLSearchParams({
        page: window.location.pathname
      }));
    });
</script>
<script src="css/scripts/index.js"></script>