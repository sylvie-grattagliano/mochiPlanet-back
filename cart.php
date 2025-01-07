<?php
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
<?php include('./includes/navbar.php'); ?>

    <header>
        <h1>Votre panier</h1>
    </header>

    <main>
    <main>
    <section class="cart">
      <h2>Vous pouvez à tout moment actualiser vos achats</h2>
      <ul class="cart-items">
        <!-- Les produits ajoutés s’afficheront ici dynamiquement -->
      </ul>
      <div class="cart-summary">
                <p><strong>Total à payer :</strong> <span id="cart-total">0.00 €</span></p>
                <button id="proceed-to-payment">Procéder au paiement</button>
            </div>
    </section>
  </main>
    <script src="assets/script.js"></script>
    <?php include('./includes/footer.php'); ?>
</body>

</html>