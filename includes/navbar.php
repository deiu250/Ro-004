<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    a {
    color: inherit;
    text-decoration: none;
    text-shadow: rgb(150, 222, 248) 1px 0 7px;
}

a:visited {
    color: inherit;
}

nav {
    display: flex;
    flex-direction: row;
    font-size: 1.5vw;
    font-weight: 900;
    color: #77BDD9;
    background-color: rgb(0, 0, 0);
    font-family: 'Bahnschrift', sans-serif;
    text-shadow: 2px 2px 5px rgba(255, 255, 255, 0.067);
    position: sticky;
    top: 0;
    /* Sticks to the top of the viewport */
    z-index: 1000;
    /* Ensures it stays above other elements */
}


nav div {
    margin-right: 30px;
}

nav img {
    flex-direction: row-reverse;
    align-items: end;
    text-align: end;
    place-items: end;
}
#navbar {
  position: relative;
  top: 0;
  transition: top 0.6s ease, opacity 0.6s ease, transform 0.6s ease;
  opacity: 1;
  transform: translateY(0);
}
#navbar.hidden {
  top: -100px;
  opacity: 0;
  transform: translateY(-20px);
}

</style>
<nav id="navbar" style="padding: 40px;">
    <div><a href="index.php">Home</a></div>
    <div><a href="sponsori.php">Sponsor Us</a></div>
    <div><a href="AkinaCorns.php">AkinaCorns</a></div>
    <div><a href="Team.php">Team</a></div>
    <img src="logo _png.png" alt="" style="position: absolute; top:2vh; right: 0; width:7rem; height: auto;">
</nav>
<script>
let lastScrollTop = 0;
const navbar = document.getElementById("navbar");

window.addEventListener("scroll", function() {
  const scrollTop = window.scrollY || document.documentElement.scrollTop;

  if (scrollTop > lastScrollTop) {
    // Scroll în jos → ascunde cu clasa .hidden
    navbar.classList.add("hidden");
  } else {
    // Scroll în sus → arată
    navbar.classList.remove("hidden");
  }

  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
});
</script>
