<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "includes/db.php";

// $host = 'localhost';
// $dbname = 'mochiplanet';
// $username = 'root';
// $password = '';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['id'])) {
    // Récupérer un produit par ID
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id =:id");
    $stmt->execute(['id' => $_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_OBJ);
    // Retourner les produits en JSON
    echo json_encode($product);
} else {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id");
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($products);
}
