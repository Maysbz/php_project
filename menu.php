<?php
require_once __DIR__ . '/init.php';
ensure_session();
$menu = get_menu();
$menuByCategory = $menu['menuByCategory'] ?: get_fallback_menu();
$menuWarning = $menu['menuWarning'];
render_page_head('Menu');
render_header('menu.php');
?>

<section class="menu-section">
  <div class="page-intro">
    <h1 class="menu-title">Notre menu</h1>
    <p class="discount-description">Découvrez nos entrées, plats, desserts et boissons.</p>
  </div>

  <?php if ($menuWarning): ?>
    <div class="alert alert-error"><?php echo e($menuWarning); ?></div>
  <?php endif; ?>

  <?php foreach ($menuByCategory as $categorie => $plats): ?>
    <div class="menu-category">
      <h2><?php echo e($categorie); ?></h2>
      <ul class="menu-items">
        <?php foreach ($plats as $plat): ?>
          <li class="menu-item">
            <img src="<?php echo e(asset_url($plat['image'])); ?>" alt="<?php echo e($plat['nom']); ?>">
            <div class="item-details">
              <h3><?php echo e($plat['nom']); ?></h3>
              <?php if (!empty($plat['description'])): ?>
                <p class="item-description"><?php echo e($plat['description']); ?></p>
              <?php endif; ?>
              <p class="item-price"><?php echo number_format((float) $plat['prix'], 2); ?> TND</p>
              <a href="commande.php?plat_id=<?php echo e($plat['id']); ?>" class="order-btn">Commander</a>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endforeach; ?>
</section>

<section class="specialties-section">
  <h2 class="section-title">Nos spécialités</h2>
  <div class="specialties-container">
    <div class="specialty-item">
      <img src="images/samboussek.jpeg" alt="Sambousek" class="specialty-img">
      <h3>Sambousek</h3>
      <p>Chausson croustillant, emblème de la cuisine du Moyen-Orient.</p>
      <a href="commande.php" class="order-btn">Commander</a>
    </div>
    <div class="specialty-item">
      <img src="images/warakenab.jpg" alt="Warak enab" class="specialty-img">
      <h3>Warak enab</h3>
      <p>Feuilles de vigne garnies de riz, viande et épices.</p>
      <a href="commande.php" class="order-btn">Commander</a>
    </div>
    <div class="specialty-item">
      <img src="images/kebba.jpg" alt="Kebba" class="specialty-img">
      <h3>Kebba</h3>
      <p>Croquettes farcies de viande, oignons et pignons.</p>
      <a href="commande.php" class="order-btn">Commander</a>
    </div>
  </div>
</section>

<?php render_footer(); ?>
