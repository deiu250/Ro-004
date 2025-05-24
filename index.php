<?php include_once ("includes/vizite.php");?>
<!DOCTYPE html>
<html>

<head>
    <title>ROBOCORNS</title>
    <link rel="icon" type="image/jpeg" href="includes/logo.jpg">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="intothedeep">
            <h2>Into the deep</h2>
            <div class="award-container">
                <div class="award">
                    <p>Inspire Award 2 - Etapa Regională</p>
                    <div class="award-img-container">
                        <img src="materiale/inspire-award.jpg" alt="Inspire Award">
                        <div class="award-description">
                            Se oferă echipei care are un impact major în comunitate și demonstrează leadership autentic,
                            fiind totodata un ambasador FIRST TECH CHALLENGE. Acesta este premiul cel mai ravnit din
                            competiție.
                        </div>
                    </div>
                </div>

                <div class="award">
                    <p>Judges Award-Etapa Nationala</p>
                    <img src="materiale/judgesaward.jpg" alt="Judges Award">
                    <div class="award-description">
                        Se oferă echipei care are un impact major în comunitate și demonstrează leadership autentic,
                        fiind totodata un ambasador FIRST TECH CHALLENGE. Acesta este premiul cel mai ravnit din
                        competiție.
                    </div>
                </div>
            </div>
        </div>
        <div class="centerstage">
            <h2>Center stage</h2>
            <div class="award-container">
                <div class="award">
                    <p>Design Award 2-Etapa Regionala</p>
                    <img src="materiale/design2.jpg" alt="Design Award">
                    <div class="award-description">
                        Se oferă echipei care are un impact major în comunitate și demonstrează leadership autentic,
                        fiind totodata un ambasador FIRST TECH CHALLENGE. Acesta este premiul cel mai ravnit din
                        competiție.
                    </div>
                </div>
            </div>
        </div>
        <div class="powerplay">
            <h2>Power play</h2>
            <div class="award-container">
                <div class="award">
                    <p>Innovate Award 3-Etapa Nationala</p>
                    <img src="materiale/innovate3.jpg" alt="Innovate Award">
                    <div class="award-description">
                        Se oferă echipei care are un impact major în comunitate și demonstrează leadership autentic,
                        fiind totodata un ambasador FIRST TECH CHALLENGE. Acesta este premiul cel mai ravnit din
                        competiție.
                    </div>
                </div>
            </div>
        </div>
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