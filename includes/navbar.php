<?php
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mochi Planet</title>
  <link rel="stylesheet" href="assets/catalogue.css">
</head>

<body>


  <nav class="navbar">
    <div class="logo-container">
      <img src="upload/logo-mochi-2.PNG" alt="mochi" class="nav-logo">
      <span class="site-title">Mochi Planet</span>
    </div>
    <div class="menu-burger" id="menu-burger">
      <i class="fas fa-bars"></i>
    </div>
    <ul class="nav-links" id="nav-links">
      <li><a href="index.php">Accueil</a></li>
      <li><a href="catalogue.php">Catalogue</a></li>
      <li> <a href="cart.php">Mon Panier</a>

    </ul>
    <div class="nav-icons">
      <a href="login.php" class="icon-link">
        <i class="fas fa-user"></i>
      </a>
    </div>

    <!-- js pour click burger -->
    <script>
      const menuBurger = document.getElementById("menu-burger");
      const navLinks = document.getElementById("nav-links");

      menuBurger.addEventListener("click", () => {
        navLinks.classList.toggle("active");
      });
    </script>
  </nav>
</body>

</html>