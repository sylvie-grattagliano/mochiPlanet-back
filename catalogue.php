<?php
// Exemple de connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=mochiplanet', 'root', '');

// Récupérer les produits depuis la base de données
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mochi Planet </title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/catalogue.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include('./includes/navbar.php'); ?>
        <h1>Découvrez nos Mochi artisanaux</h1>
    </header>
    <main>
        <!-- Section Hero -->
        <section class="hero">

            <div class="hero-content">
                <h1>Bienvenue sur Mochi Planet</h1>
                <p>Découvrez nos Mochi artisanaux</p>
            </div>
        </section>

        <main>
        <div class="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card" 
                    data-id="<?php echo $product['id']; ?>" 
                    data-name="<?php echo htmlspecialchars($product['name']); ?>" 
                    data-price="<?php echo htmlspecialchars($product['price']); ?>">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p><strong><?php echo number_format($product['price'], 2); ?> €</strong></p>
                    <!-- Lien dynamique  -->
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-view">Voir produit</a>
                    <button class="btn-add-to-cart">Ajouter au panier</button>
                </div>
            <?php endforeach; ?>
        </div>
        </section>

    <a href="cart.php" class="btn-floating-cart">🛒 Voir le Panier</a>
    </section>
    
    </main>


        <script src="assets/catalogue.js"></script>
        <?php include 'includes/footer.php'; ?>
</body>

</html>