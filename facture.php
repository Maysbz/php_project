<?php
require_once __DIR__ . '/init.php';
require_user();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST)) {
    redirect(page_url('commande.php'));
}

$name = trim($_POST['name'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');
$address = trim($_POST['address'] ?? '');
$instructions = trim($_POST['instructions'] ?? '');
$plats = $_POST['plats'] ?? [];
$numero_facture = strtoupper(substr(md5(uniqid('', true)), 0, 8));
$date_facture = date('d/m/Y');
$heure_facture = date('H:i');
$commande = [];
$sous_total = 0;

foreach ($plats as $plat) {
    $parts = explode('|', $plat);
    if (count($parts) !== 2) continue;
    $nomPlat = trim($parts[0]);
    $prix = (int) $parts[1];
    if ($nomPlat === '' || $prix <= 0) continue;
    $commande[] = ['nom' => $nomPlat, 'prix' => $prix];
    $sous_total += $prix;
}

$tva = round($sous_total * 0.10, 2);
$total = round($sous_total + $tva, 2);
$save_error = '';

if ($commande) {
    try {
        save_order(['name' => $name, 'telephone' => $telephone, 'address' => $address, 'instructions' => $instructions], $commande, $total);
    } catch (Throwable $e) {
        $save_error = "La facture est affichee, mais la commande n'a pas pu etre enregistree en base.";
    }
}

$name = e($name);
$telephone = e($telephone);
$address = e($address);
$instructions = e($instructions);
foreach ($commande as $i => $item) {
    $commande[$i]['nom'] = e($item['nom']);
    $commande[$i]['prix'] = e($item['prix']);
}
render_page_head('Facture');
render_header('');
?>

  <section class="invoice-section">
    <div class="invoice-container">

      <?php if (!empty($save_error)): ?>
        <div class="alert alert-error">
          <?php echo e($save_error); ?>
        </div>
      <?php endif; ?>

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
<?php render_footer(); ?>

