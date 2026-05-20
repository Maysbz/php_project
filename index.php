<?php require_once __DIR__ . '/init.php'; ensure_session(); render_page_head('Accueil'); render_header('index.php'); ?>

<section class="resto">
  <div class="resto-content">
    <h1>Bienvenue chez Damascino</h1>
    <p>Cuisine levantine authentique — saveurs syriennes dans une ambiance chaleureuse.</p>
    <a href="menu.php" class="btn">Explorer le menu</a>
  </div>
</section>

<section class="features">
  <div class="feature">
    <h2>Ingrédients frais</h2>
    <p>Produits sélectionnés et préparés avec soin chaque jour.</p>
  </div>
  <div class="feature">
    <h2>Cadre chaleureux</h2>
    <p>Une ambiance conviviale et élégante au bord du lac.</p>
  </div>
  <div class="feature">
    <h2>Saveurs d'exception</h2>
    <p>Des recettes traditionnelles transmises avec passion.</p>
  </div>
</section>

<section class="gallery">
  <h2>Nos meilleurs moments</h2>
  <div class="gallery-images">
    <img src="images/platdel.png" alt="Plat délicieux">
    <img src="images/place.jpg" alt="Salle élégante">
    <img src="images/specialité.jpg" alt="Plats signature">
    <img src="images/event.png" alt="Moment convivial">
  </div>
</section>

<section class="cta">
  <h2>Réservez votre table</h2>
  <p>Vivez une expérience culinaire unique chez Damascino.</p>
  <a href="reservation.php" class="btn">Réserver maintenant</a>
</section>

<section class="testimonials">
  <h2>Ce que disent nos clients</h2>
  <div class="testimonial">
    <p>« Food is delish, service is excellent. The waiters are very kind and helpful. Place is very clean — highly recommend! »</p>
    <h4>— Marwa Saidi</h4>
  </div>
  <div class="testimonial">
    <p>« Very happy to find a place of quality and service. Great place, great service and great food. »</p>
    <h4>— Sam Jabraouti</h4>
  </div>
</section>

<?php render_footer(); ?>
