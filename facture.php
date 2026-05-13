<?php
session_start();

// Rediriger vers login si non connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Rediriger vers commande si on arrive sans données
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
    header("Location: commande.php");
    exit();
}

// ── Connexion base de données ───────────────────────────────
$host   = 'localhost';
$dbname = 'damascino_db';
$user   = 'root';
$pass   = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
// ────────────────────────────────────────────────────────────

// Récupération des infos client
$name         = htmlspecialchars(trim($_POST['name']));
$telephone    = htmlspecialchars(trim($_POST['telephone']));
$address      = htmlspecialchars(trim($_POST['address']));
$instructions = htmlspecialchars(trim($_POST['instructions'] ?? ''));
$plats        = $_POST['plats'] ?? [];

// Génération d'un numéro de facture unique
$numero_facture = strtoupper(substr(md5(uniqid()), 0, 8));
$date_facture   = date('d/m/Y');
$heure_facture  = date('H:i');

// Traitement des plats et calcul du total
$commande   = [];
$sous_total = 0;

foreach ($plats as $plat) {
    $parts = explode('|', $plat);
    if (count($parts) === 2) {
        $nom_plat   = htmlspecialchars($parts[0]);
        $prix       = intval($parts[1]);
        $commande[] = ['nom' => $nom_plat, 'prix' => $prix];
        $sous_total += $prix;
    }
}

$tva   = round($sous_total * 0.10, 2);
$total = round($sous_total + $tva, 2);

// ── Sauvegarde en base de données (seulement si des plats sont sélectionnés) ──
if (!empty($commande)) {
    try {
        // 1. Insérer la commande
        $stmt = $pdo->prepare("
            INSERT INTO commande (nom, telephone, adresse, instructions, total)
            VALUES (:nom, :telephone, :adresse, :instructions, :total)
        ");
        $stmt->execute([
            ':nom'          => $name,
            ':telephone'    => $telephone,
            ':adresse'      => $address,
            ':instructions' => $instructions,
            ':total'        => $total
        ]);
        $commande_id = $pdo->lastInsertId();

        // 2. Insérer chaque ligne de commande
        $stmt2 = $pdo->prepare("
            INSERT INTO ligne_commande (commande_id, nom_plat, prix)
            VALUES (:commande_id, :nom_plat, :prix)
        ");
        foreach ($commande as $item) {
            $stmt2->execute([
                ':commande_id' => $commande_id,
                ':nom_plat'    => $item['nom'],
                ':prix'        => $item['prix']
            ]);
        }

        // 3. Insérer la facture
        $stmt3 = $pdo->prepare("
            INSERT INTO facture (commande_id, montant_total)
            VALUES (:commande_id, :montant_total)
        ");
        $stmt3->execute([
            ':commande_id'   => $commande_id,
            ':montant_total' => $total
        ]);

    } catch (PDOException $e) {
        die("Erreur lors de la sauvegarde : " . $e->getMessage());
    }
}
// ────────────────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Facture</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .invoice-container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 40px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid #8B0000;
      padding-bottom: 20px;
      margin-bottom: 25px;
    }
    .invoice-logo {
      font-size: 2rem;
      font-weight: bold;
      color: #8B0000;
    }
    .invoice-meta {
      text-align: right;
      font-size: 0.9rem;
      color: #555;
    }
    .invoice-meta p { margin: 3px 0; }
    .customer-info {
      background: #f9f9f9;
      border-radius: 8px;
      padding: 15px 20px;
      margin-bottom: 25px;
    }
    .customer-info p { margin: 5px 0; }
    .invoice-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    .invoice-table th {
      background: #8B0000;
      color: #fff;
      padding: 10px 15px;
      text-align: left;
    }
    .invoice-table td {
      padding: 10px 15px;
      border-bottom: 1px solid #eee;
    }
    .invoice-table tr:last-child td { border-bottom: none; }
    .invoice-table tr:nth-child(even) td { background: #f9f9f9; }
    .invoice-summary {
      text-align: right;
      border-top: 2px solid #8B0000;
      padding-top: 15px;
    }
    .invoice-summary p { margin: 6px 0; font-size: 0.95rem; }
    .invoice-summary .total-final {
      font-size: 1.3rem;
      font-weight: bold;
      color: #8B0000;
    }
    .invoice-instructions {
      background: #fff8e1;
      border-left: 4px solid #f0ad4e;
      padding: 12px 16px;
      border-radius: 4px;
      margin: 20px 0;
      font-size: 0.9rem;
    }
    .thank-you {
      text-align: center;
      font-size: 1.1rem;
      color: #8B0000;
      margin: 25px 0 10px;
    }
    .btn-actions {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 20px;
      flex-wrap: wrap;
    }
    .btn-print {
      background: #8B0000;
      color: #fff;
      border: none;
      padding: 12px 28px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
    }
    .btn-back {
      background: #555;
      color: #fff;
      padding: 12px 28px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 1rem;
    }
    .empty-order {
      text-align: center;
      color: #c0392b;
      padding: 30px;
      font-size: 1.1rem;
    }
    @media print {
      header, footer, .btn-actions { display: none !important; }
      .invoice-container { box-shadow: none; border: none; }
    }
  </style>
</head>
<body>
  <header class="main-header">
    <div class="logo">damascino</div>
    <nav class="navbar">
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="about.php">À propos</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="reservation.php">Réservation</a></li>
        <li><a href="discount.php">Offres</a></li>
        <li><a href="logout.php" class="Connexion">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

  <section class="invoice-section">
    <div class="invoice-container">

      <!-- En-tête facture -->
      <div class="invoice-header">
        <div>
          <div class="invoice-logo">damascino</div>
          <p style="color:#555; font-size:0.85rem;">Rue de la Feuille d'Érable, Tunis 1053</p>
          <p style="color:#555; font-size:0.85rem;">+216 53 888 880</p>
        </div>
        <div class="invoice-meta">
          <p><strong>Facture N° :</strong> #<?php echo $numero_facture; ?></p>
          <p><strong>Date :</strong> <?php echo $date_facture; ?></p>
          <p><strong>Heure :</strong> <?php echo $heure_facture; ?></p>
        </div>
      </div>

      <!-- Infos client -->
      <div class="customer-info">
        <p><strong>👤 Client :</strong> <?php echo $name; ?></p>
        <p><strong>📞 Téléphone :</strong> <?php echo $telephone; ?></p>
        <p><strong>📍 Adresse :</strong> <?php echo $address; ?></p>
      </div>

      <?php if (empty($commande)): ?>
        <div class="empty-order">
          <p>⚠️ Aucun plat sélectionné.</p>
          <a href="commande.php" class="btn-back" style="display:inline-block; margin-top:15px;">Retour à la commande</a>
        </div>

      <?php else: ?>
        <!-- Tableau des plats -->
        <table class="invoice-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Plat</th>
              <th>Prix</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($commande as $i => $item): ?>
              <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $item['nom']; ?></td>
                <td><?php echo $item['prix']; ?> TND</td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <!-- Instructions spéciales -->
        <?php if (!empty($instructions)): ?>
          <div class="invoice-instructions">
            <strong>📝 Instructions spéciales :</strong> <?php echo $instructions; ?>
          </div>
        <?php endif; ?>

        <!-- Résumé financier -->
        <div class="invoice-summary">
          <p><strong>Sous-total :</strong> <?php echo $sous_total; ?> TND</p>
          <p><strong>TVA (10%) :</strong> <?php echo $tva; ?> TND</p>
          <p class="total-final">Total : <?php echo $total; ?> TND</p>
        </div>

        <p class="thank-you">🍽️ Merci pour votre commande ! Nous la préparons avec soin.</p>

        <!-- Boutons d'action -->
        <div class="btn-actions">
          <button class="btn-print" onclick="window.print()">🖨️ Imprimer la facture</button>
          <a href="commande.php" class="btn-back">➕ Nouvelle commande</a>
          <a href="index.php" class="btn-back">🏠 Accueil</a>
        </div>

      <?php endif; ?>

    </div>
  </section>

  <footer class="main-footer">
    <div class="footer-container">
      <div class="footer-section about">
        <h3>À propos de nous</h3>
        <p>Damascino vous invite à un voyage culinaire au cœur de la Syrie, où l'authenticité des saveurs levantines rencontre la générosité d'un accueil chaleureux.</p>
      </div>
      <div class="footer-section contact">
        <h3>Contactez-nous</h3>
        <p><strong>Adresse :</strong> Rue de la Feuille d'Érable, Tunis 1053</p>
        <p><strong>Téléphone :</strong> +216 53 888 880</p>
        <p><strong>Email :</strong> contact@damascino.tn</p>
      </div>
      <div class="footer-section hours">
        <h3>Horaires d'ouverture</h3>
        <ul>
          <li>Lundi - Vendredi : 11h - 23h</li>
          <li>Samedi - Dimanche : 11h - 00h</li>
        </ul>
      </div>
      <div class="footer-section social">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
          <a href="https://www.facebook.com/damascino.orientalfood" class="social-icon"><img src="facebook.png" alt="Facebook"></a>
          <a href="https://www.instagram.com/damascino.orientalfood/" class="social-icon"><img src="insta.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2023 damascino. Tous droits réservés.</p>
    </div>
  </footer>

</body>
</html>