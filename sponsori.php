<!DOCTYPE html>
<html>

<head>
    <title>ROBOCORNS</title>
    <link rel="icon" type="image/jpeg" href="css/inuse/logo _png.png">
    <link rel="stylesheet" type="text/css" href="css/sponsori.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
</head>

<?php include_once("includes/navbar.php")?>
<body>
    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
  <script>
    alert("Mesajul a fost trimis cu succes! Mulțumim pentru susținere!");
  </script>
<?php endif; ?>
    <header>
        SPONSOR US
    </header>
    <article>
        <p
            style="text-align: center; color: #77BDD9; font-family: 'Bahnschrift', sans-serif; font-size: 1.5vw; margin-top: 20px;">
            Dacă doriți să ne susțineți, vă rugăm să vă exprimați dorința în formularul de mai jos care ne v-a informa
            printr-un mail de intențiile dumneavoastră.
            <br>
            Vă mulțumim pentru sprijinul
            acordat!
        </p>
    </article>
    <section>
        <div class="left">
            <h2>PORTOFOLIU</h2>
            <iframe src="css/inuse/Portofoliu_romana_APROBAT (2).pdf#toolbar=0&navpanes=0&scrollbar=0" style="border: none;"></iframe>
        </div>
        <div class="right">
            <h2>Formular</h2>
            <form action="includes/mail.php" method="post">
                <input type="text" name="nume" placeholder="Numele firmei" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="text" name="suma" id="suma" placeholder="Suma" required>
                <textarea name="mesaj" placeholder="Mesaj opțional"></textarea>
                <button type="submit">Trimite</button>
            </form>
        </div>
    </section>
    <?php include ("includes/footer.php")?>
</body>

</html>