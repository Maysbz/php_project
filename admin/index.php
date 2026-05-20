<?php
include 'auth.php';
include 'functions.php';

$stats = get_stats();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Damascino</title>
    <link rel="stylesheet" href="<?php echo e(versioned_asset_href('../style.css')); ?>">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            opacity: 0.9;
            text-transform: uppercase;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
        }
        .admin-navbar {
            background-color: #333;
            padding: 0;
            margin-bottom: 20px;
        }
        .admin-navbar ul {
            list-style: none;
            display: flex;
            gap: 0;
            margin: 0;
            padding: 0;
        }
        .admin-navbar li {
            margin: 0;
        }
        .admin-navbar a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .admin-navbar a:hover {
            background-color: #667eea;
        }
        .recent-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .recent-table th {
            background-color: #333;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .recent-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .recent-table tr:hover {
            background-color: #f5f5f5;
        }
        .admin-section {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Dashboard Admin</h1>
        
        <?php admin_menu(); ?>
        
        <div class="dashboard-grid">
            <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3>Total Plats</h3>
                <div class="number"><?php echo $stats['total_plats']; ?></div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>Réservations ce mois</h3>
                <div class="number"><?php echo $stats['reservations_mois']; ?></div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>Contacts non lus</h3>
                <div class="number"><?php echo $stats['contacts_non_lus']; ?></div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>Offres Actives</h3>
                <div class="number"><?php echo $stats['offres_actives']; ?></div>
            </div>
            <div class="stat-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <h3>Commandes</h3>
                <div class="number"><?php echo $stats['commandes_total']; ?></div>
            </div>
        </div>

        <div class="admin-section">
            <h2>Accès rapide</h2>
            <ul>
                <li><a href="<?php echo e(admin_url('manage/produits.php')); ?>">Gérer les plats</a></li>
                <li><a href="<?php echo e(admin_url('manage/commandes.php')); ?>">Voir les commandes</a></li>
                <li><a href="<?php echo e(admin_url('manage/reservations.php')); ?>">Gérer les réservations</a></li>
                <li><a href="<?php echo e(admin_url('manage/clients.php')); ?>">Voir les clients</a></li>
                <li><a href="<?php echo e(admin_url('manage/offres.php')); ?>">Gérer les offres</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
