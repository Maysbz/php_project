<?php
include 'auth.php';
include 'functions.php';

$commandes = get_all_commandes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Commandes - Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .admin-navbar { background-color: #333; padding: 0; margin-bottom: 20px; }
        .admin-navbar ul { list-style: none; display: flex; gap: 0; margin: 0; padding: 0; }
        .admin-navbar li { margin: 0; }
        .admin-navbar a { display: block; padding: 15px 20px; color: white; text-decoration: none; transition: background-color 0.3s; }
        .admin-navbar a:hover { background-color: #667eea; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .commandes-table { width: 100%; border-collapse: collapse; }
        .commandes-table th { background-color: #333; color: white; padding: 12px; text-align: left; }
        .commandes-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .commandes-table tr:hover { background-color: #f5f5f5; }
        .message { padding: 20px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Gestion des Commandes</h1>
        
        <?php admin_menu(); ?>
        
        <div class="table-container">
            <?php if ($commandes && mysqli_num_rows($commandes) > 0): ?>
                <table class="commandes-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($commande = mysqli_fetch_assoc($commandes)): ?>
                            <tr>
                                <td><?php echo $commande['id']; ?></td>
                                <td><?php echo htmlspecialchars($commande['client'] ?? 'N/A'); ?></td>
                                <td><?php echo isset($commande['total']) ? number_format($commande['total'], 2) : '0.00'; ?> TND</td>
                                <td><?php echo htmlspecialchars($commande['statut'] ?? 'N/A'); ?></td>
                                <td><?php echo isset($commande['date_creation']) ? date('d/m/Y H:i', strtotime($commande['date_creation'])) : 'N/A'; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="message">Aucune commande trouvée. La table commande n'existe pas encore ou est vide.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
