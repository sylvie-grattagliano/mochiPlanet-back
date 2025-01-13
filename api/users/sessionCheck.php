<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


header("Access-Control-Allow-Origin: http://localhost:5173"); // Permet toutes les origines (à restreindre en production)
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Méthodes autorisées
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // En-têtes autorisés
header("Content-Type: application/json"); // Définir le type de réponse en JSON
if (isset($_SESSION['user_id'])) {
    echo json_encode([
        'logged_in' => true,
        'user' => [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
        ],
    ]);
} else {
    echo json_encode([
        'logged_in' => false,
        'message' => 'Aucune session active.',
    ]);
}
