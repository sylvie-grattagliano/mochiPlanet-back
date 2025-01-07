<!-- pour deconnection -->
<?php
session_start();
session_destroy(); // Détruire toutes les sessions
header("Location: index.php"); // Rediriger vers la page d'accueil
exit;
?>