<?php

if (empty($name) || empty($email) || empty($password)) {
    $error = "Tous les champs sont obligatoires.";
} else {
    try {
        // Insertion dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);

        // Redirection après une inscription réussie
        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        // Gérer les erreurs d'email dupliqué ou autres problèmes
        if ($e->getCode() === '23000') { // Contrainte UNIQUE sur l'email
            $error = "Cet email est déjà utilisé.";
        } else {
            $error = "Une erreur est survenue : " . $e->getMessage();
        }
    }
}

?>

<?php
// Démarrage de la session
session_start();

// Inclusion de la connexion à la base de données
include 'includes/db.php';

$error = ""; // Variable pour stocker les erreurs

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation basique
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        try {
            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $password]);

            // Redirection après une inscription réussie
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            // Gérer les erreurs d'email dupliqué ou autres problèmes
            if ($e->getCode() === '23000') { // Contrainte UNIQUE sur l'email
                $error = "Cet email est déjà utilisé.";
            } else {
                $error = "Une erreur est survenue : " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="assets/login.css">
</head>
<body>
    <div class="register-container">
        <h1>Inscription</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="text" id="password" name="password" required>
            
            <button type="submit">S'inscrire</button>
        </form>
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous ici</a></p>
    </div>
</body>
</html>
