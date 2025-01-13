<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include "../../includes/db.php";



// Traiter les requêtes OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $user_id = $_SESSION['user_id'] ?? null;
    $product_id = $data['product_id'] ?? null;
    $quantity = $data['quantity'] ?? 1;

    if (!$user_id || !$product_id) {
        echo json_encode(['success' => false, 'error' => 'Données manquantes : user_id ou product_id.']);
        exit;
    }

    // Vérifiez si le produit est déjà dans le panier
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id]);
    $existingProduct = $stmt->fetch(PDO::FETCH_OBJ);

    if ($existingProduct) {
        // Mettre à jour la quantité si le produit est déjà dans le panier
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE id = :id");
        $stmt->execute(['quantity' => $quantity, 'id' => $existingProduct->id]);
    } else {
        // Ajouter un nouveau produit au panier
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'quantity' => $quantity]);
    }

    echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier.']);
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
