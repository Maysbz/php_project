<?php
include 'auth.php';
include 'functions.php';

$message = '';
$error = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create') {
        $code = trim($_POST['code'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $reduction = trim($_POST['reduction'] ?? '');
        $date_debut = trim($_POST['date_debut'] ?? '');
        $date_fin = trim($_POST['date_fin'] ?? '');
        
        if (!$code || !$nom || !$reduction || !$date_debut || !$date_fin) {
            $error = "Tous les champs sont obligatoires.";
        } elseif ($reduction < 1 || $reduction > 100) {
            $error = "La réduction doit être entre 1 et 100%.";
        } else {
            if (create_offre($code, $nom, $reduction, $date_debut, $date_fin)) {
                $message = "Offre créée avec succès !";
            } else {
                $error = "Erreur lors de la création de l'offre.";
            }
        }
    }
    
    if ($action === 'update') {
        $id = intval($_POST['id'] ?? 0);
        $code = trim($_POST['code'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $reduction = trim($_POST['reduction'] ?? '');
        $date_debut = trim($_POST['date_debut'] ?? '');
        $date_fin = trim($_POST['date_fin'] ?? '');
        $actif = intval($_POST['actif'] ?? 0);
        
        if (!$id || !$code || !$nom || !$reduction || !$date_debut || !$date_fin) {
            $error = "Tous les champs sont obligatoires.";
        } elseif ($reduction < 1 || $reduction > 100) {
            $error = "La réduction doit être entre 1 et 100%.";
        } else {
            if (update_offre($id, $code, $nom, $reduction, $date_debut, $date_fin, $actif)) {
                $message = "Offre mise à jour avec succès !";
            } else {
                $error = "Erreur lors de la mise à jour.";
            }
        }
    }
    
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id && delete_offre($id)) {
            $message = "Offre supprimée avec succès !";
        } else {
            $error = "Erreur lors de la suppression.";
        }
    }
}

// Récupérer les offres
$offres = get_all_offres();

// Récupérer l'offre à éditer si nécessaire
$edit_offre = null;
if (isset($_GET['edit'])) {
    // Récupérer directement de la BDD
    global $conn;
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM offre WHERE id = $id");
    $edit_offre = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Offres - Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .admin-navbar { background-color: #333; padding: 0; margin-bottom: 20px; }
        .admin-navbar ul { list-style: none; display: flex; gap: 0; margin: 0; padding: 0; }
        .admin-navbar li { margin: 0; }
        .admin-navbar a { display: block; padding: 15px 20px; color: white; text-decoration: none; transition: background-color 0.3s; }
        .admin-navbar a:hover { background-color: #667eea; }
        .form-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .btn { padding: 10px 20px; margin-right: 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-primary { background-color: #667eea; color: white; }
        .btn-primary:hover { background-color: #5568d3; }
        .btn-danger { background-color: #f5576c; color: white; }
        .btn-danger:hover { background-color: #d94556; }
        .btn-secondary { background-color: #999; color: white; }
        .btn-secondary:hover { background-color: #777; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 15px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
        .offres-table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .offres-table th { background-color: #333; color: white; padding: 12px; text-align: left; }
        .offres-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .offres-table tr:hover { background-color: #f5f5f5; }
        .badge-active { background-color: #d4edda; color: #155724; padding: 3px 8px; border-radius: 3px; }
        .badge-inactive { background-color: #f8d7da; color: #721c24; padding: 3px 8px; border-radius: 3px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Gestion des Offres Promotionnelles</h1>
        
        <?php admin_menu(); ?>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <!-- Formulaire Ajouter/Éditer -->
        <div class="form-section">
            <h2><?php echo $edit_offre ? 'Éditer l\'offre' : 'Créer une nouvelle offre'; ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?php echo $edit_offre ? 'update' : 'create'; ?>">
                <?php if ($edit_offre): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_offre['id']; ?>">
                <?php endif; ?>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="code">Code Promo:</label>
                        <input type="text" id="code" name="code" required value="<?php echo htmlspecialchars($edit_offre['code'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="reduction">Réduction (%):</label>
                        <input type="number" id="reduction" name="reduction" min="1" max="100" required value="<?php echo htmlspecialchars($edit_offre['reduction'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="nom">Nom de l'offre:</label>
                    <input type="text" id="nom" name="nom" required value="<?php echo htmlspecialchars($edit_offre['nom'] ?? ''); ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date_debut">Date de début:</label>
                        <input type="date" id="date_debut" name="date_debut" required value="<?php echo htmlspecialchars($edit_offre['date_debut'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="date_fin">Date de fin:</label>
                        <input type="date" id="date_fin" name="date_fin" required value="<?php echo htmlspecialchars($edit_offre['date_fin'] ?? ''); ?>">
                    </div>
                </div>
                
                <?php if ($edit_offre): ?>
                    <div class="form-group">
                        <label for="actif">
                            <input type="checkbox" id="actif" name="actif" value="1" <?php echo $edit_offre['actif'] ? 'checked' : ''; ?>>
                            Offre active
                        </label>
                    </div>
                <?php endif; ?>
                
                <div>
                    <button type="submit" class="btn btn-primary"><?php echo $edit_offre ? 'Mettre à jour' : 'Créer'; ?></button>
                    <?php if ($edit_offre): ?>
                        <a href="offres.php" class="btn btn-secondary">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Liste des offres -->
        <div class="form-section">
            <h2>Liste des offres</h2>
            <table class="offres-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Réduction</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($offre = mysqli_fetch_assoc($offres)): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($offre['code']); ?></strong></td>
                            <td><?php echo htmlspecialchars($offre['nom']); ?></td>
                            <td><?php echo htmlspecialchars($offre['reduction']); ?>%</td>
                            <td><?php echo date('d/m/Y', strtotime($offre['date_debut'])); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($offre['date_fin'])); ?></td>
                            <td>
                                <span class="<?php echo $offre['actif'] ? 'badge-active' : 'badge-inactive'; ?>">
                                    <?php echo $offre['actif'] ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td>
                                <a href="?edit=<?php echo $offre['id']; ?>" class="btn btn-primary">Éditer</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $offre['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
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
