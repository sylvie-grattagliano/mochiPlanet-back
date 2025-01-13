<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include "../../includes/db.php";

// Traiter les requêtes OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non connecté.']);
        exit;
    }

//     // Récupérer les produits du panier pour cet utilisateur
//     $stmt = $pdo->prepare("
//         SELECT cart.id, cart.quantity, products.name, products.price, products.image
//         FROM cart
//         INNER JOIN products ON cart.product_id = products.id
//         WHERE cart.user_id = :user_id
//     ");
//     $stmt->execute(['user_id' => $user_id]);
//     $cartItems = $stmt->fetchAll(PDO::FETCH_OBJ);

//     echo json_encode(['success' => true, 'data' => $cartItems]);
// } else {
//     echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
// }
try {
    $stmt = $pdo->prepare("SELECT c.*, p.name, p.price, p.image FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = :user_id");
    $stmt->execute([':user_id' => $user_id]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode(['success' => true, 'data' => $cart_items]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
}
