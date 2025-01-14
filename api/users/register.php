<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../../includes/db.php"; // Inclure la connexion à la base de données

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Pré-vol OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Vérification méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Méthode non autorisée."]);
    exit;
}

// Récupération des données envoyées
$data = json_decode(file_get_contents("php://input"), true);

// Vérification des champs requis
if (!isset($data['name'], $data['first_name'], $data['email'], $data['password'])) {
    echo json_encode(["success" => false, "message" => "Tous les champs sont requis."]);
    exit;
}

// Nettoyage des données utilisateur
$name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
$first_name = htmlspecialchars($data['first_name'], ENT_QUOTES, 'UTF-8');
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$password = $data['password'];

// Validation email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Adresse email invalide."]);
    exit;
}

// Vérification longueur du mot de passe
if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Le mot de passe doit contenir au moins 8 caractères."]);
    exit;
}

try {
    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "message" => "Cet email est déjà utilisé."]);
        exit;
    }

    // Hacher le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insérer l'utilisateur
    $stmt = $pdo->prepare("INSERT INTO users (name, first_name, email, password) VALUES (:name, :first_name, :email, :password)");
    $stmt->execute([
        'name' => $name,
        'first_name' => $first_name,
        'email' => $email,
        'password' => $hashedPassword,
    ]);

    echo json_encode(["success" => true, "message" => "Inscription réussie."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Une erreur est survenue : " . $e->getMessage()]);
}
