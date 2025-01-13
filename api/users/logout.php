<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// En-têtes pour autoriser les requêtes CORS
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

session_unset();
session_destroy();

header("Content-Type: application/json");
echo json_encode([
    'success' => true,
    'message' => 'Déconnexion réussie.',
]);
