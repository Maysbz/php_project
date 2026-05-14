<?php
include 'auth.php';
include 'functions.php';

$message = '';
$error = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create') {
        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');
        $categorie = trim($_POST['categorie'] ?? '');
        
        if (!$nom || !$prix || !$categorie) {
            $error = "Les champs nom, prix et catégorie sont obligatoires.";
        } else {
            $image = 'images/default.jpg';
            
            // Traiter l'upload image
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $upload = upload_image($_FILES['image']);
                if ($upload['success']) {
                    $image = $upload['path'];
                } else {
                    $error = $upload['error'];
                }
            }
            
            if (!$error) {
                if (create_plat($nom, $description, $prix, $categorie, $image)) {
                    $message = "Plat créé avec succès !";
                } else {
                    $error = "Erreur lors de la création du plat.";
                }
            }
        }
    }
    
    if ($action === 'update') {
        $id = intval($_POST['id'] ?? 0);
        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $prix = trim($_POST['prix'] ?? '');
        $categorie = trim($_POST['categorie'] ?? '');
        
        if (!$id || !$nom || !$prix || !$categorie) {
            $error = "Les champs sont obligatoires.";
        } else {
            $plat = get_plat_by_id($id);
            $image = $plat['image'];
            
            // Traiter l'upload image
            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                $upload = upload_image($_FILES['image']);
                if ($upload['success']) {
                    $image = $upload['path'];
                } else {
                    $error = $upload['error'];
                }
            }
            
            if (!$error) {
                if (update_plat($id, $nom, $description, $prix, $categorie, $image)) {
                    $message = "Plat mis à jour avec succès !";
                } else {
                    $error = "Erreur lors de la mise à jour.";
                }
            }
        }
    }
    
    if ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id && delete_plat($id)) {
            $message = "Plat supprimé avec succès !";
        } else {
            $error = "Erreur lors de la suppression.";
        }
    }
}

// Récupérer les plats
$plats = get_all_plats();

// Récupérer le plat à éditer si nécessaire
$edit_plat = null;
if (isset($_GET['edit'])) {
    $edit_plat = get_plat_by_id(intval($_GET['edit']));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Produits - Admin</title>
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
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .form-group textarea { resize: vertical; min-height: 100px; }
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
        .plats-table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .plats-table th { background-color: #333; color: white; padding: 12px; text-align: left; }
        .plats-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .plats-table tr:hover { background-color: #f5f5f5; }
        .plat-image { max-width: 50px; height: auto; border-radius: 4px; }
        .image-preview { max-width: 200px; margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Gestion des Produits</h1>
        
        <?php admin_menu(); ?>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <!-- Formulaire Ajouter/Éditer -->
        <div class="form-section">
            <h2><?php echo $edit_plat ? 'Éditer le plat' : 'Ajouter un nouveau plat'; ?></h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo $edit_plat ? 'update' : 'create'; ?>">
                <?php if ($edit_plat): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_plat['id']; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="nom">Nom du plat:</label>
                    <input type="text" id="nom" name="nom" required value="<?php echo htmlspecialchars($edit_plat['nom'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($edit_plat['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="prix">Prix (TND):</label>
                    <input type="number" id="prix" name="prix" step="0.01" required value="<?php echo htmlspecialchars($edit_plat['prix'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="categorie">Catégorie:</label>
                    <select id="categorie" name="categorie" required>
                        <option value="">Sélectionner une catégorie</option>
                        <option value="Entrées" <?php echo ($edit_plat['categorie'] ?? '') === 'Entrées' ? 'selected' : ''; ?>>Entrées</option>
                        <option value="Plats principaux" <?php echo ($edit_plat['categorie'] ?? '') === 'Plats principaux' ? 'selected' : ''; ?>>Plats principaux</option>
                        <option value="Desserts" <?php echo ($edit_plat['categorie'] ?? '') === 'Desserts' ? 'selected' : ''; ?>>Desserts</option>
                        <option value="Boissons" <?php echo ($edit_plat['categorie'] ?? '') === 'Boissons' ? 'selected' : ''; ?>>Boissons</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <?php if ($edit_plat && $edit_plat['image']): ?>
                        <p>Image actuelle:</p>
                        <img src="../<?php echo htmlspecialchars($edit_plat['image']); ?>" class="plat-image">
                    <?php endif; ?>
                    <img id="imagePreview" class="image-preview" style="display:none;">
                </div>
                
                <div>
                    <button type="submit" class="btn btn-primary"><?php echo $edit_plat ? 'Mettre à jour' : 'Ajouter'; ?></button>
                    <?php if ($edit_plat): ?>
                        <a href="produits.php" class="btn btn-secondary">Annuler</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Liste des plats -->
        <div class="form-section">
            <h2>Liste des plats</h2>
            <table class="plats-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($plat = mysqli_fetch_assoc($plats)): ?>
                        <tr>
                            <td>
                                <img src="../<?php echo htmlspecialchars($plat['image']); ?>" class="plat-image" alt="<?php echo htmlspecialchars($plat['nom']); ?>">
                            </td>
                            <td><?php echo htmlspecialchars($plat['nom']); ?></td>
                            <td><?php echo htmlspecialchars($plat['categorie']); ?></td>
                            <td><?php echo number_format($plat['prix'], 2); ?> TND</td>
                            <td>
                                <a href="?edit=<?php echo $plat['id']; ?>" class="btn btn-primary">Éditer</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $plat['id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        // Preview image avant upload
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('imagePreview').src = event.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
