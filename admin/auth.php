<?php

require_once __DIR__ . '/../init.php';

ensure_session();

if (!isset($_SESSION['user'])) {
    redirect(admin_url('auth/login.php'));
}
$userEmail = $_SESSION['user'];
$isAdmin = ($_SESSION['role'] ?? '') === 'admin' || user_is_admin($userEmail);

if (!$isAdmin) {
    http_response_code(403);
    die("Acces refuse. Vous n'etes pas autorise a acceder a cette section.");
}

function admin_menu(): void
{
    echo '<nav class="admin-navbar">
        <ul>
            <li><a href="' . e(admin_url('index.php')) . '">Dashboard</a></li>
            <li><a href="' . e(admin_url('manage/produits.php')) . '">Produits</a></li>
            <li><a href="' . e(admin_url('manage/commandes.php')) . '">Commandes</a></li>
            <li><a href="' . e(admin_url('manage/reservations.php')) . '">Reservations</a></li>
            <li><a href="' . e(admin_url('manage/clients.php')) . '">Clients</a></li>
            <li><a href="' . e(admin_url('manage/offres.php')) . '">Offres</a></li>
            <li><a href="' . e(admin_url('auth/logout.php')) . '">Deconnexion</a></li>
        </ul>
    </nav>';
}
