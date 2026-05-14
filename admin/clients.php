<?php
include 'auth.php';
include 'functions.php';

// Récupérer tous les contacts
$contacts = get_all_contacts();
$message = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = intval($_POST['id'] ?? 0);
    $status = $_POST['status'] ?? '';
    
    if ($action === 'update_status' && $id && in_array($status, ['non lu', 'lu', 'traite'])) {
        if (update_contact_status($id, $status)) {
            $message = "Statut mis à jour avec succès !";
        }
    }
}

// Recharger les contacts après la mise à jour
$contacts = get_all_contacts();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Clients/Contacts - Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .admin-navbar { background-color: #333; padding: 0; margin-bottom: 20px; }
        .admin-navbar ul { list-style: none; display: flex; gap: 0; margin: 0; padding: 0; }
        .admin-navbar li { margin: 0; }
        .admin-navbar a { display: block; padding: 15px 20px; color: white; text-decoration: none; transition: background-color 0.3s; }
        .admin-navbar a:hover { background-color: #667eea; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px; }
        .contacts-table { width: 100%; border-collapse: collapse; }
        .contacts-table th { background-color: #333; color: white; padding: 12px; text-align: left; }
        .contacts-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .contacts-table tr:hover { background-color: #f5f5f5; }
        .status-badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; }
        .status-non_lu { background-color: #fff3cd; color: #856404; }
        .status-lu { background-color: #cce5ff; color: #004085; }
        .status-traite { background-color: #d4edda; color: #155724; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px; }
        .btn-primary { background-color: #667eea; color: white; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 15px; background-color: #d4edda; color: #155724; }
        .message-preview { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .btn-view { background-color: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Gestion des Clients & Contacts</h1>
        
        <?php admin_menu(); ?>
        
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="table-container">
            <h2>Messages de contact reçus</h2>
            <table class="contacts-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($contact = mysqli_fetch_assoc($contacts)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($contact['nom']); ?></td>
                            <td><?php echo htmlspecialchars($contact['email']); ?></td>
                            <td class="message-preview" title="<?php echo htmlspecialchars($contact['message']); ?>"><?php echo htmlspecialchars(substr($contact['message'], 0, 50)) . '...'; ?></td>
                            <td>
                                <span class="status-badge status-<?php echo str_replace(' ', '_', $contact['statut']); ?>">
                                    <?php echo htmlspecialchars($contact['statut']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($contact['date_envoi'])); ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?php echo $contact['id']; ?>">
                                    <select name="status" class="btn" style="width: auto; padding: 5px;">
                                        <option value="non lu" <?php echo $contact['statut'] === 'non lu' ? 'selected' : ''; ?>>Non lu</option>
                                        <option value="lu" <?php echo $contact['statut'] === 'lu' ? 'selected' : ''; ?>>Lu</option>
                                        <option value="traite" <?php echo $contact['statut'] === 'traite' ? 'selected' : ''; ?>>Traité</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
            <h2>Gestion des Offres Promotionnelles</h2>
            <a href="offres.php" class="btn btn-primary" style="margin-bottom: 15px;">Gérer les offres</a>
        </div>
    </div>
</body>
</html>
