<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../includes/db.php";


// $host = 'localhost';
// $dbname = 'mochiplanet';
// $username = 'root';
// $password = '';

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Nécessaire pour les sessions et cookies
header("Content-Type: application/json");

// $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id'])) {
    // Récupérer un user par ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id =:id");
    $stmt->$user = $stmt->fetch(PDO::FETCH_OBJ);
    // Retourner le user en JSON
    echo json_encode($user);
} else {
    $stmt = $conn->query("SELECT * FROM users ORDER BY id");
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($users);
}
