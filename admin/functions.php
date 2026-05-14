<?php
include '../db.php';

// ===== PLATS =====
function get_all_plats() {
    global $conn;
    $query = "SELECT * FROM plat ORDER BY categorie, nom";
    return mysqli_query($conn, $query);
}

function get_plat_by_id($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM plat WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function create_plat($nom, $description, $prix, $categorie, $image) {
    global $conn;
    $nom = mysqli_real_escape_string($conn, $nom);
    $description = mysqli_real_escape_string($conn, $description);
    $categorie = mysqli_real_escape_string($conn, $categorie);
    $image = mysqli_real_escape_string($conn, $image);
    $prix = floatval($prix);
    
    $query = "INSERT INTO plat (nom, description, prix, categorie, image) 
              VALUES ('$nom', '$description', $prix, '$categorie', '$image')";
    return mysqli_query($conn, $query);
}

function update_plat($id, $nom, $description, $prix, $categorie, $image) {
    global $conn;
    $id = intval($id);
    $nom = mysqli_real_escape_string($conn, $nom);
    $description = mysqli_real_escape_string($conn, $description);
    $categorie = mysqli_real_escape_string($conn, $categorie);
    $image = mysqli_real_escape_string($conn, $image);
    $prix = floatval($prix);
    
    $query = "UPDATE plat SET nom='$nom', description='$description', prix=$prix, 
              categorie='$categorie', image='$image' WHERE id=$id";
    return mysqli_query($conn, $query);
}

function delete_plat($id) {
    global $conn;
    $id = intval($id);
    $query = "DELETE FROM plat WHERE id = $id";
    return mysqli_query($conn, $query);
}

// ===== RÉSERVATIONS =====
function get_all_reservations() {
    global $conn;
    $query = "SELECT * FROM reservation_table ORDER BY date_reservation DESC, heure_reservation DESC";
    return mysqli_query($conn, $query);
}

function update_reservation_status($id, $status) {
    global $conn;
    $id = intval($id);
    $status = mysqli_real_escape_string($conn, $status);
    $query = "UPDATE reservation_table SET status='$status' WHERE id=$id";
    return mysqli_query($conn, $query);
}

// ===== COMMANDES =====
function get_all_commandes() {
    global $conn;
    // Si la table commande existe
    if (check_table_exists('commande')) {
        $query = "SELECT * FROM commande ORDER BY date_creation DESC";
        return mysqli_query($conn, $query);
    }
    return false;
}

// ===== CONTACTS =====
function get_all_contacts() {
    global $conn;
    $query = "SELECT * FROM contact ORDER BY date_envoi DESC";
    return mysqli_query($conn, $query);
}

function update_contact_status($id, $status) {
    global $conn;
    $id = intval($id);
    $status = mysqli_real_escape_string($conn, $status);
    $query = "UPDATE contact SET statut='$status' WHERE id=$id";
    return mysqli_query($conn, $query);
}

// ===== OFFRES =====
function get_all_offres() {
    global $conn;
    $query = "SELECT * FROM offre ORDER BY date_debut DESC";
    return mysqli_query($conn, $query);
}

function create_offre($code, $nom, $reduction, $date_debut, $date_fin) {
    global $conn;
    $code = mysqli_real_escape_string($conn, $code);
    $nom = mysqli_real_escape_string($conn, $nom);
    $reduction = intval($reduction);
    
    $query = "INSERT INTO offre (code, nom, reduction, date_debut, date_fin) 
              VALUES ('$code', '$nom', $reduction, '$date_debut', '$date_fin')";
    return mysqli_query($conn, $query);
}

function update_offre($id, $code, $nom, $reduction, $date_debut, $date_fin, $actif) {
    global $conn;
    $id = intval($id);
    $code = mysqli_real_escape_string($conn, $code);
    $nom = mysqli_real_escape_string($conn, $nom);
    $reduction = intval($reduction);
    $actif = intval($actif);
    
    $query = "UPDATE offre SET code='$code', nom='$nom', reduction=$reduction, 
              date_debut='$date_debut', date_fin='$date_fin', actif=$actif WHERE id=$id";
    return mysqli_query($conn, $query);
}

function delete_offre($id) {
    global $conn;
    $id = intval($id);
    $query = "DELETE FROM offre WHERE id = $id";
    return mysqli_query($conn, $query);
}

// ===== STATISTIQUES =====
function get_stats() {
    global $conn;
    $stats = [];
    
    // Total plats
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM plat");
    $stats['total_plats'] = mysqli_fetch_assoc($result)['total'];
    
    // Total réservations (ce mois)
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM reservation_table 
                                   WHERE MONTH(date_reservation) = MONTH(NOW())");
    $stats['reservations_mois'] = mysqli_fetch_assoc($result)['total'];
    
    // Total contacts (non lus)
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM contact WHERE statut='non lu'");
    $stats['contacts_non_lus'] = mysqli_fetch_assoc($result)['total'];
    
    // Total offres actives
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM offre WHERE actif=1");
    $stats['offres_actives'] = mysqli_fetch_assoc($result)['total'];
    
    return $stats;
}

// ===== UTILITAIRES =====
function check_table_exists($table_name) {
    global $conn;
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$table_name'");
    return mysqli_num_rows($result) > 0;
}

function upload_image($file, $upload_dir = '../images/') {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_ext)) {
        return ['success' => false, 'error' => 'Format de fichier non autorisé.'];
    }
    
    if ($file['size'] > 5 * 1024 * 1024) { // 5MB
        return ['success' => false, 'error' => 'Le fichier est trop volumineux (max 5MB).'];
    }
    
    // Générer un nom unique
    $new_name = 'plat_' . time() . '.' . $file_ext;
    $upload_path = $upload_dir . $new_name;
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return ['success' => true, 'path' => 'images/' . $new_name];
    }
    
    return ['success' => false, 'error' => 'Erreur lors de l\'upload du fichier.'];
}
?>
