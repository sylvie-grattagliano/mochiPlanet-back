<?php
// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=mochiplanet', 'root', '');

// Récupérer l'ID du produit depuis l'URL
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    // Récupérer les détails du produit
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le produit n'existe pas, afficher un message d'erreur
    if (!$product) {
        die("Produit introuvable.");
    }
} else {
    die("ID de produit manquant.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="assets/style.css">
    
</head>

<style>
    .product-details {
        background-image: url('upload/fond.jpg');

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<body>
<?php include('./includes/navbar.php'); ?>

    <header class="product-header">
        <div class="title-container">
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        </div>
        <div class="button-container">
            <a href="index.php" class="btn-return">Retour au Catalogue</a>
        </div>
    </header>

    <main>
        <section class="product-details">

            <div class="image-container">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="details">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p><strong>Prix :</strong> <?php echo number_format($product['price'], 2); ?> €</p>
                <form action="cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <label for="quantity">Quantité :</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                    <button type="submit">Ajouter au Panier</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>