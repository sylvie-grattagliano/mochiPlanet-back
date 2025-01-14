<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../../includes/db.php";

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if (!$email || !$password) {
        echo json_encode(["success" => false, "error" => "Email et mot de passe requis."]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        // Vérifier si l'utilisateur existe et si le mot de passe correspond
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;

            echo json_encode([
                "success" => true,
                "message" => "Connexion réussie.",
                "user" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Email ou mot de passe incorrect."]);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => "Erreur serveur : " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
