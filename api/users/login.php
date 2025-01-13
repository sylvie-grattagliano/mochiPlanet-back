<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
}
include "../../includes/db.php"; // Inclure la connexion à la base de données

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Nécessaire pour les sessions et cookies
// header("Content-Type: application/json");

header("Content-Type: application/json");



// Vérifier si la méthode HTTP utilisée est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données JSON envoyées depuis le frontend
    $data = json_decode(file_get_contents("php://input"), true);
    // Extraire l'email et le mot de passe
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    // Vérifier que l'email et le mot de passe sont fournis
    if (!$email || !$password) {
        // echo json_encode([
        //     'success' => false,
        //     'error' => 'Email et mot de passe requis.'
        // ]);
        echo json_encode([
            "session_id" => session_id(),
            "session_data" => $_SESSION,
            "cookies" => $_COOKIE,
        ]);
        exit;
    }

    try {
        // Rechercher l'utilisateur dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_OBJ); // Récupérer les données sous forme d'objet

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && $user->password === $password) { // Si vous utilisez un hachage, remplacez par password_verify
            // Stocker les informations utilisateur dans la session
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;

            // Retourner les informations utilisateur
            echo json_encode([
                'success' => true,
                'message' => 'Connexion réussie.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]);
        } else {
            // Réponse en cas d'erreur de connexion
            echo json_encode([
                'success' => false,
                'error' => 'Email ou mot de passe incorrect.'
            ]);
        }
    } catch (Exception $e) {
        // Gestion des erreurs serveur
        echo json_encode([
            'success' => false,
            'error' => 'Une erreur est survenue : ' . $e->getMessage()
        ]);
    }
} else {
    // Si la méthode HTTP n'est pas POST, renvoyer une erreur
    echo json_encode([
        'success' => false,
        'error' => 'Méthode non autorisée.'
    ]);
    exit;
}
