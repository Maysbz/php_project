<?php
include 'db.php';

// Récupérer les catégories disponibles
$categories_query = "SELECT DISTINCT categorie FROM plat WHERE actif = 1 ORDER BY categorie";
$categories_result = mysqli_query($conn, $categories_query);
$categories = [];
while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories[] = $row['categorie'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Menu</title>
  <link rel="stylesheet" href="style.css">
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
          <li><a href="login.php"  class="Connexion">Connexion</a></li>
        </ul>
    </nav>
</header>

<section class="menu-section">
  <h1 class="menu-title">Notre Menu</h1>

  <?php foreach ($categories as $categorie): ?>
    <?php
      $plats_query = "SELECT * FROM plat WHERE categorie = '" . mysqli_real_escape_string($conn, $categorie) . "' AND actif = 1";
      $plats_result = mysqli_query($conn, $plats_query);
    ?>
    <div class="menu-category">
      <h2><?php echo htmlspecialchars($categorie); ?></h2>
      <ul class="menu-items">
        <?php while ($plat = mysqli_fetch_assoc($plats_result)): ?>
          <li class="menu-item">
            <img src="<?php echo htmlspecialchars($plat['image']); ?>" alt="<?php echo htmlspecialchars($plat['nom']); ?>">
            <div class="item-details">
              <h3><?php echo htmlspecialchars($plat['nom']); ?></h3>
              <?php if ($plat['description']): ?>
                <p class="item-description"><?php echo htmlspecialchars($plat['description']); ?></p>
              <?php endif; ?>
              <p class="item-price">Prix : <?php echo number_format($plat['prix'], 2); ?> TND</p>
              <a href="commande.php?plat_id=<?php echo $plat['id']; ?>" class="order-btn">Commander</a>   
            </div>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  <?php endforeach; ?>

</section>

<!-- footer -->
  <footer class="main-footer">
    <div class="footer-container">
      <!-- About Us Section -->
      <div class="footer-section about">
        <h3>À propos de nous</h3>
        <p>Damascino vous invite à un voyage culinaire au cœur de la Syrie, où l'authenticité des saveurs levantines rencontre la générosité d'un accueil chaleureux.</p>
      </div>
  
      <!-- Contact Section -->
      <div class="footer-section contact">
        <h3>Contactez-nous</h3>
        <p><strong>Adresse :</strong> Rue de la Feuille d'Érable, Tunis 1053</p>
        <p><strong>Téléphone :</strong> +216 53 888 880</p>
        <p><strong>Email :</strong> contact@damascino.tn</p>
      </div>
  
      <!-- Hours Section -->
      <div class="footer-section hours">
        <h3>Horaires d'ouverture</h3>
        <ul>
          <li>Lundi - Vendredi : 11h - 23h</li>
          <li>Samedi - Dimanche : 11h - 00h</li>
        </ul>
      </div>
  
      <!-- Social Media Section -->
      <div class="footer-section social">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
          <a href="https://www.facebook.com/damascino.orientalfood" class="social-icon"><img src="images/facebook.png" alt="Facebook"></a>
          <a href="https://www.instagram.com/damascino.orientalfood/" class="social-icon"><img src="images/insta.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2023 damascino. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>
</section>
<!-- Section Nos Spécialités -->
<section class="specialties-section">
  <h2 class="section-title">Nos Spécialités</h2>
  <div class="specialties-container">
    <div class="specialty-item">
      <img src="images/samboussek.jpeg" alt="Sambousek" class="specialty-img">
      <h3>Sambousek</h3>
      <p> un chausson salé croustillant, emblématique de la cuisine du Moyen-Orient, particulièrement au Liban, en Syrie, en Jordanie et en Égypte.</p>
      <a href="commande.php" class="order-btn">Commander</a>     
    </div>
    <div class="specialty-item">
      <img src="images/warakenab.jpg" alt="Warak enab" class="specialty-img">
      <h3>Warak enab</h3>
      <p>un plat emblématique de la cuisine levantine et méditerranéenne. Garni d'un mélange de riz, de viande hachée et d'épices comme la cannelle et le sept-épices. </p>
      <a href="commande.php" class="order-btn">Commander</a>     
    </div>
    <div class="specialty-item">
      <img src="images/kebba.jpg" alt="Kebba" class="specialty-img">
      <h3>Kebba</h3>
      <p>croquettes en forme de ballon de rugby, dont la coque (viande et boulgour) est farcie d'un mélange de viande sautée, d'oignons et de pignons de pin.</p>
      <a href="commande.php" class="order-btn">Commander</a>     
    </div>
  </div>
</section>





 
<!-- footer -->
  <footer class="main-footer">
    <div class="footer-container">
      <!-- About Us Section -->
      <div class="footer-section about">
        <h3>À propos de nous</h3>
        <p>Damascino vous invite à un voyage culinaire au cœur de la Syrie, où l'authenticité des saveurs levantines rencontre la générosité d'un accueil chaleureux.</p>
      </div>
  
      <!-- Contact Section -->
      <div class="footer-section contact">
        <h3>Contactez-nous</h3>
        <p><strong>Adresse :</strong> Rue de la Feuille d'Érable, Tunis 1053</p>
        <p><strong>Téléphone :</strong> +216 53 888 880</p>
        <p><strong>Email :</strong> contact@damascino.tn</p>
      </div>
  
      <!-- Hours Section -->
      <div class="footer-section hours">
        <h3>Horaires d'ouverture</h3>
        <ul>
          <li>Lundi - Vendredi : 11h - 23h</li>
          <li>Samedi - Dimanche : 11h - 00h</li>
        </ul>
      </div>
  
      <!-- Social Media Section -->
      <div class="footer-section social">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
          <a href="https://www.facebook.com/damascino.orientalfood" class="social-icon"><img src="images/facebook.png" alt="Facebook"></a>
          <a href="https://www.instagram.com/damascino.orientalfood/" class="social-icon"><img src="images/insta.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2023 damascino. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>
