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

  <!-- Entrées -->
  <div class="menu-category">
    <h2>Entrées</h2>
    <ul class="menu-items">
      <li class="menu-item">
        <img src="images/soupe.jpg" alt="Soupe aux lentilles">
        <div class="item-details">
          <h3>Soupe aux lentilles</h3>
          <p>Prix : 15 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/Fattouch.jpg" alt="Fattouch">
        <div class="item-details">
          <h3>Fattouch</h3>
          <p>Prix : 10 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/maza.jpg" alt="Maza">
        <div class="item-details">
          <h3>Maza</h3>
          <p>Prix : 20 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
    </ul>
  </div>

  <!-- Plats principaux -->
  <div class="menu-category">
    <h2>Plats principaux</h2>
    <ul class="menu-items">
      <li class="menu-item">
        <img src="images/kebabmix.jpg" alt="Kebab mixte">
        <div class="item-details">
          <h3>Kebab mixte</h3>
          <p>Prix : 80 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/majouka.jpg" alt="Majouka">
        <div class="item-details">
          <h3>Majouka</h3>
          <p>Prix : 30 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/mandi.png" alt="Mandi poulet">
        <div class="item-details">
          <h3>Mandi poulet</h3>
          <p>Prix : 40 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
    </ul>
  </div>

  <!-- Desserts -->
  <div class="menu-category">
    <h2>Desserts</h2>
    <ul class="menu-items">
      <li class="menu-item">
        <img src="images/tiramisu.jpg" alt="Tiramisu">
        <div class="item-details">
          <h3>Tiramisu</h3>
          <p>Prix : 10 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/kunefa.jpg" alt="Kunefa">
        <div class="item-details">
          <h3>Kunefa</h3>
          <p>Prix : 30 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/layalilibnan.jpg" alt="Layali lebnan">
        <div class="item-details">
          <h3>Layali lebnan</h3>
          <p>Prix : 15 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
    </ul>
  </div>

  <!-- Boissons -->
  <div class="menu-category">
    <h2>Boissons</h2>
    <ul class="menu-items">
      <li class="menu-item">
        <img src="images/citronade.jpeg" alt="Citronnade">
        <div class="item-details">
          <h3>Citronnade</h3>
          <p>Prix : 9 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>   
        </div>
      </li>
      <li class="menu-item">
        <img src="images/Thé_à_la_Menthe.jpg" alt="Thé à la Menthe">
        <div class="item-details">
          <h3>Thé à la Menthe</h3>
          <p>Prix : 12 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>
        </div>
      </li>
      <li class="menu-item">
        <img src="images/ayran.jpg" alt="Ayrane">
        <div class="item-details">
          <h3>Ayrane</h3>
          <p>Prix : 10 TND</p>
          <a href="commande.php" class="order-btn">Commander</a>     
         </div>
      </li>
    </ul>
  </div>
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
