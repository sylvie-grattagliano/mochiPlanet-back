<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mochi Planet </title>
  <link rel="stylesheet" href="assets/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
  <!-- <header>

</header> -->
  <?php include('./includes/navbar.php'); ?>
  <main>
    <!-- Section Hero -->
    <section class="hero">
      <img src="upload/mochi2.jpg" alt="Image Hero" class="hero-image">
      <div class="hero-content">
        <h1>Bienvenue sur Mochi Planet</h1>
        <p>Découvrez nos Mochi artisanaux, faits avec amour pour toutes vos envies sucrées !</p>
      </div>
    </section>

    <!-- Section Produits -->
    <section class="product-list">
      <h2>Produits du mois</h2>
      <div class="product-grid">
        <!-- Produit 1 -->
        <div class="product-card" data-id="1" data-name="Mochi vanille" data-price="2.50">
          <img src="upload/mochi1.jpg" alt="Mochi vanille">
          <h3>Mochi le Parfait</h3>
          <p>Prix : 2.50 €</p>
          <button onclick="addToCart(1)">Acheter</button>
          <a href="product.php?id=1" class="btn-view">Voir produit</a>


        </div>

        <!-- Produit 2 -->
        <div class="product-card" data-id="2" data-name="Mochi Matcha" data-price="3.00">
          <img src="./upload/mochi2.jpg" alt="Mochi Matcha">
          <h3>Mochi le bonheur</h3>
          <p>Prix : 3.00 €</p>
          <button onclick="addToCart(2)">Acheter</button>
          <a href="product.php?id=2" class="btn-view">Voir produit</a>
        </div>


        <!-- Produit 3 -->
        <div class="product-card" data-id="3" data-name="Dango" data-price="2.80">
          <img src="./upload/dango1.jpg" alt="Dango">
          <h3>Dango</h3>
          <p>Prix : 3.50 €</p>

          <button onclick="addToCart(3)">Acheter</button>
          <a href="product.php?id=3" class="btn-view">Voir produit</a>
        </div>

    </section>

    <a href="cart.php" class="btn-floating-cart">🛒 Voir le Panier</a>
    </section>
  </main>

  <script src="assets/script.js"></script>
  <?php include 'includes/footer.php'; ?>
</body>

</html>