<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Offres de réduction</title>
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

  <section class="discount-section">
    <h1 class="discount-title">Nos Offres de Réduction</h1>
    <p class="discount-description">Découvrez nos promotions spéciales et profitez d'offres exceptionnelles sur vos plats préférés !</p>

    <div class="discount-container">
      <!-- Offre 1 -->
      <div class="discount-card">
        <img src="images/kebabmix.jpg" alt="Kebab mixte" class="discount-image">
        <h3 class="discount-name">Kebab mixte</h3>
        <p class="discount-details">Obtenez 20% de réduction sur notre Kebab mixte !</p>
        <p class="discount-price"><del>80DT</del> 64DT</p>
        <a href="signup.php" class="btn-redeem">Profiter de l'offre</a>
      </div>

      <!-- Offre 2 -->
      <div class="discount-card">
        <img src="images/mandi.png" alt="Mandi poulet" class="discount-image">
        <h3 class="discount-name">Mandi poulet</h3>
        <p class="discount-details">Une réduction de 15% sur  notre Mandi poulet !</p>
        <p class="discount-price"><del>40DT</del> 34DT</p>
        <a href="signup.php" class="btn-redeem">Profiter de l'offre</a>
      </div>

      <!-- Offre 3 -->
      <div class="discount-card">
        <img src="images/kunefa.jpg" alt="Kunefa" class="discount-image">
        <h3 class="discount-name">Kunefa</h3>
        <p class="discount-details">Réduction de 10% sur notre délicieuse kunefa !</p>
        <p class="discount-price"><del>30DT</del> 27DT</p>
        <a href="signup.php" class="btn-redeem">Profiter de l'offre</a>
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
