<?php
include '../auth.php';
include '../functions.php';

$message = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    
    if ($action === 'update_status' && $id && in_array($status, ['en attente', 'confirmee', 'annulee'])) {
        if (update_reservation_status($id, $status)) {
            $message = "Réservation mise à jour avec succès !";
        }
    }
}

$reservations = get_all_reservations();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Réservations - Admin</title>
    <link rel="stylesheet" href="<?php echo e(versioned_asset_href('../../style.css')); ?>">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .admin-navbar { background-color: #333; padding: 0; margin-bottom: 20px; }
        .admin-navbar ul { list-style: none; display: flex; gap: 0; margin: 0; padding: 0; }
        .admin-navbar li { margin: 0; }
        .admin-navbar a { display: block; padding: 15px 20px; color: white; text-decoration: none; transition: background-color 0.3s; }
        .admin-navbar a:hover { background-color: #667eea; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .reservations-table { width: 100%; border-collapse: collapse; }
        .reservations-table th { background-color: #333; color: white; padding: 12px; text-align: left; }
        .reservations-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .reservations-table tr:hover { background-color: #f5f5f5; }
        .status-badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; }
        .status-attente { background-color: #fff3cd; color: #856404; }
        .status-confirmee { background-color: #d4edda; color: #155724; }
        .status-annulee { background-color: #f8d7da; color: #721c24; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px; }
        .btn-primary { background-color: #667eea; color: white; }
        .btn-danger { background-color: #f5576c; color: white; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 15px; background-color: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Gestion des Réservations</h1>
        
        <?php admin_menu(); ?>
        
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="table-container">
            <table class="reservations-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Personnes</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($res = mysqli_fetch_assoc($reservations)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($res['nom']); ?></td>
                            <td><?php echo htmlspecialchars($res['email']); ?></td>
                            <td><?php echo htmlspecialchars($res['telephone']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($res['date_reservation'])); ?></td>
                            <td><?php echo htmlspecialchars($res['heure_reservation']); ?></td>
                            <td><?php echo htmlspecialchars($res['nb_personnes']); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo str_replace(' ', '_', $res['status']); ?>">
                                    <?php echo htmlspecialchars($res['status']); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                                    <select name="status" class="btn" style="width: auto; padding: 5px;">
                                        <option value="en attente" <?php echo $res['status'] === 'en attente' ? 'selected' : ''; ?>>En attente</option>
                                        <option value="confirmee" <?php echo $res['status'] === 'confirmee' ? 'selected' : ''; ?>>Confirmée</option>
                                        <option value="annulee" <?php echo $res['status'] === 'annulee' ? 'selected' : ''; ?>>Annulée</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
