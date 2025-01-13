<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Headers CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");


header("Content-Type: application/json");


include "../../includes/db.php"; // Inclure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    // DEBUG
    // var_dump($input);
    // file_put_contents('debug.log', "Update Request Received: " . print_r($input, true) . "\n", FILE_APPEND);

    if (!isset($input['product_id'], $input['quantity_delta'])) {
        echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
        exit;
    }

    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non connecté']);
        exit;
    }

    $product_id = $input['product_id'];
    $quantity_delta = $input['quantity_delta'];
    // Debug des variables utilisées dans la requête
    // var_dump($user_id, $product_id, $quantity_delta);

    try {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + :delta WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            ':delta' => $quantity_delta,
            ':user_id' => $user_id,
            ':product_id' => $product_id,
        ]);
        

        // Récupérer le panier mis à jour
        $cart_stmt = $pdo->prepare("SELECT c.*, p.name, p.price, p.image FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = :user_id");
        $cart_stmt->execute([':user_id' => $user_id]);
        $cart_items = $cart_stmt->fetchAll(PDO::FETCH_OBJ);

        echo json_encode(['success' => true, 'data' => $cart_items]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}