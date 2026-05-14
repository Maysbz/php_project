<?php
// Vérifier si l'utilisateur est connecté et est admin
session_start();

// Rediriger vers login si pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Vérifier si c'est un admin (vous devrez ajouter une colonne 'role' à la table users)
// Pour l'instant, on suppose que l'admin est défini dans le fichier users.json ou en dur
$admins = ['admin@damascino.tn', 'owner@damascino.tn']; // À adapter selon votre système d'authentification

// Si vous utilisez la BDD, décommenter la section suivante:
/*
include '../db.php';
$user_id = $_SESSION['user_id'];
$user_query = "SELECT role FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($result);

if (!$user || $user['role'] !== 'admin') {
    die("Accès refusé. Vous n'êtes pas autorisé à accéder à cette section.");
}
*/

// Pour l'instant, vérifier dans users.json
$users_file = '../users.json';
if (file_exists($users_file)) {
    $users_data = json_decode(file_get_contents($users_file), true);
    $user_email = $users_data[$_SESSION['user_id']]['email'] ?? '';
    
    if (!in_array($user_email, $admins)) {
        die("Accès refusé. Vous n'êtes pas autorisé à accéder à cette section.");
    }
}

// Fonction pour afficher le menu admin
function admin_menu() {
    echo '<nav class="admin-navbar">
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="produits.php">Produits</a></li>
            <li><a href="commandes.php">Commandes</a></li>
            <li><a href="reservations.php">Réservations</a></li>
            <li><a href="clients.php">Clients</a></li>
            <li><a href="../logout.php">Déconnexion</a></li>
        </ul>
    </nav>';
}
?>
