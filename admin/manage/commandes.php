<?php
include '../auth.php';
include '../functions.php';

$message = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    
    if ($action === 'update_status' && $id && in_array($status, ['en attente', 'confirmee', 'annulee'], true)) {
        if (update_commande_status($id, $status)) {
            $message = "Commande mise a jour avec succes.";
        }
    }
}

$commandes = get_all_commandes();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Commandes - Admin</title>
    <link rel="stylesheet" href="<?php echo e(versioned_asset_href('../../style.css')); ?>">
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
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 15px; background-color: #d4edda; color: #155724; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px; }
        .btn-primary { background-color: #667eea; color: white; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Gestion des Commandes</h1>
        
        <?php admin_menu(); ?>

        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="table-container">
            <?php if ($commandes && mysqli_num_rows($commandes) > 0): ?>
                <table class="commandes-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Telephone</th>
                            <th>Total</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($commande = mysqli_fetch_assoc($commandes)): ?>
                            <tr>
                                <td><?php echo $commande['id']; ?></td>
                                <td><?php echo htmlspecialchars($commande['nom'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($commande['telephone'] ?? 'N/A'); ?></td>
                                <td><?php echo isset($commande['total']) ? number_format($commande['total'], 2) : '0.00'; ?> TND</td>
                                <td><?php echo htmlspecialchars($commande['status'] ?? 'en attente'); ?></td>
                                <td><?php echo isset($commande['date_creation']) ? date('d/m/Y H:i', strtotime($commande['date_creation'])) : 'N/A'; ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="id" value="<?php echo $commande['id']; ?>">
                                        <select name="status" class="btn" style="width:auto; padding:5px;">
                                            <option value="en attente" <?php echo ($commande['status'] ?? '') === 'en attente' ? 'selected' : ''; ?>>En attente</option>
                                            <option value="confirmee" <?php echo ($commande['status'] ?? '') === 'confirmee' ? 'selected' : ''; ?>>Confirmee</option>
                                            <option value="annulee" <?php echo ($commande['status'] ?? '') === 'annulee' ? 'selected' : ''; ?>>Annulee</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary">Mettre a jour</button>
                                    </form>
                                </td>
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
