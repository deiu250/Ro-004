<?php
session_start();
session_unset(); // elimină toate variabilele de sesiune
session_destroy(); // distruge sesiunea
header("Location: login.php"); // redirecționează către pagina de login
exit();
?>