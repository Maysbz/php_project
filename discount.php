<?php require_once __DIR__ . '/init.php'; ensure_session(); render_page_head('Offres'); render_header('discount.php'); ?>

  <section class="discount-section">
    <div class="page-intro">
    <h1 class="discount-title">Nos offres</h1>
    <p class="discount-description">Promotions spéciales sur vos plats préférés.</p>
    </div>
    <div class="discount-container">
      <!-- Offre 1 -->
      <div class="discount-card">
        <img src="images/kebabmix.jpg" alt="Kebab mixte" class="discount-image">
        <h3 class="discount-name">Kebab mixte</h3>
        <p class="discount-details">Obtenez 20% de réduction sur notre Kebab mixte !</p>
        <p class="discount-price"><del>80DT</del> 64DT</p>
        <a href="<?php echo e(page_url('auth/signup.php')); ?>" class="btn-redeem">Profiter de l'offre</a>
      </div>

      <!-- Offre 2 -->
      <div class="discount-card">
        <img src="images/mandi.png" alt="Mandi poulet" class="discount-image">
        <h3 class="discount-name">Mandi poulet</h3>
        <p class="discount-details">Une réduction de 15% sur  notre Mandi poulet !</p>
        <p class="discount-price"><del>40DT</del> 34DT</p>
        <a href="<?php echo e(page_url('auth/signup.php')); ?>" class="btn-redeem">Profiter de l'offre</a>
      </div>

      <!-- Offre 3 -->
      <div class="discount-card">
        <img src="images/kunefa.jpg" alt="Kunefa" class="discount-image">
        <h3 class="discount-name">Kunefa</h3>
        <p class="discount-details">Réduction de 10% sur notre délicieuse kunefa !</p>
        <p class="discount-price"><del>30DT</del> 27DT</p>
        <a href="<?php echo e(page_url('auth/signup.php')); ?>" class="btn-redeem">Profiter de l'offre</a>
      </div>
    </div>
  </section>


<?php render_footer(); ?>
