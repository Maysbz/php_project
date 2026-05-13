<?php
session_start();

// Si déjà connecté, rediriger vers l'accueil
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Vérifier que la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$email    = htmlspecialchars(trim($_POST['email']));
$password = $_POST['password'];
$errors   = [];

// Validations de base
if (empty($email)) {
    $errors[] = "L'adresse email est obligatoire.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "L'adresse email n'est pas valide.";
}

if (empty($password)) {
    $errors[] = "Le mot de passe est obligatoire.";
}

// Si pas d'erreurs de format, chercher l'utilisateur
if (empty($errors)) {
    $users_file = 'users.json';
    $users      = [];

    if (file_exists($users_file)) {
        $users = json_decode(file_get_contents($users_file), true) ?? [];
    }

    $found = false;
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $found = true;
            // Vérifier le mot de passe hashé
            if (password_verify($password, $user['password'])) {
                // Connexion réussie
                $_SESSION['user']     = $user['email'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $errors[] = "Mot de passe incorrect.";
            }
            break;
        }
    }

    if (!$found) {
        $errors[] = "Aucun compte trouvé avec cette adresse email.";
    }
}

// En cas d'erreur : stocker dans la session et rediriger vers login.php
$_SESSION['login_errors'] = $errors;
$_SESSION['login_email']  = $email; // pour re-remplir le champ email
header("Location: login.php");
exit();
?>
