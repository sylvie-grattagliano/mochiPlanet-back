<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true"); // Nécessaire pour les sessions et cookies
header("Content-Type: application/json");

// if (isset($_SESSION['user'])) {
//     echo json_encode([
//         "success" => true,
//         "user" => $_SESSION['user'],
//     ]);
// } else {
//     echo json_encode([
//         "success" => false,
//         "error" => "Utilisateur non connecté.",
//     ]);
// }




// Vérifiez si un utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Session vide ou utilisateur non connecté']);
} else {
    echo json_encode(['success' => true, 'user_id' => $_SESSION['user_id']]);
}