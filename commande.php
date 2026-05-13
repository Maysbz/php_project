<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Commande</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header class="main-header">
    <div class="logo">damascino</div>
    <nav class="navbar">
        <ul>
          <li><a href="index.html">Accueil</a></li>
          <li><a href="menu.html">Menu</a></li>
          <li><a href="about.html">À propos</a></li>
          <li><a href="contact.html">Contact</a></li>
          <li><a href="reservation.html">Réservation</a></li>
          <li><a href="discount.html">Offres</a></li>
          <li><a href="login.html"  class="Connexion">Connexion</a></li>
        </ul>
    </nav>
</header>

  <section class="order-section">
    <h1 class="order-title">Passer une commande</h1>
    <p class="order-description">Remplissez le formulaire ci-dessous pour commander vos plats préférés. Nous préparerons votre commande dès que possible !</p>

    <div class="order-form-container">
      <form class="order-form" action="facture.html" method="POST">
        <!-- Informations personnelles -->
        <div class="form-group">
          <label for="name">Nom :</label>
          <input type="text" id="name" name="name" placeholder="Votre nom" required>
        </div>
        <div class="form-group">
          <label for="phone">Téléphone :</label>
          <input type="tel" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" required>
        </div>
        <div class="form-group">
          <label for="address">Adresse :</label>
          <input type="text" id="address" name="address" placeholder="Votre adresse complète" required>
        </div>

        <!-- Sélection des plats -->
        <h2 class="section-subtitle">Ajoutez un autre plat :</h2>
          <div class="menu-options">
            <!-- Entrées -->
            <div class="menu-item">
              <input type="checkbox" value="Soupe aux lentilles">
              <label for="dish1">Soupe aux lentilles - 15 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox"  value="Fattouch">
              <label for="dish2">Fattouch - 10 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="maza">
              <label for="dish3">Maza - 20 TND</label>
            </div>
            
            <!-- Plats principaux -->
            <div class="menu-item">
              <input type="checkbox" value="kebab mixte">
              <label for="dish4">Kebab mixte - 80 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox"  value="Mandi poulet">
              <label for="dish5">Mandi poulet - 40 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="Maajouka">
              <label for="dish6">Majouka - 30 TND</label>
            </div>
            
            <!-- Desserts -->
            <div class="menu-item">
              <input type="checkbox" value="Tiramisu">
              <label for="dish7">Tiramisu - 10 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="Kunefa">
              <label for="dish8">Kunefa - 30 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="layali lebnan">
              <label for="dish9">Layali lebnan - 15 TND</label>
            </div>

            <!-- Boissons -->
            <div class="menu-item">
              <input type="checkbox" value="citronade">
              <label for="dish10">Citronnade - 9 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="Thé à la Menthe">
              <label for="dish11">Thé à la Menthe - 12 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="ayrane">
              <label for="dish12">Ayrane - 10 TND</label>
            </div>

            <!-- Spécialités -->
            <div class="menu-item">
              <input type="checkbox" value="samboussek">
              <label for="dish13">Sambousek - 15 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="warak enab">
              <label for="dish14">Warak enab - 20 TND</label>
            </div>
            <div class="menu-item">
              <input type="checkbox" value="kebba">
              <label for="dish15">Kebba - 10 TND</label>
            </div>
          </div>

        <!-- Instructions spéciales -->
        <div class="form-group">
          <label for="instructions">Instructions spéciales :</label>
          <textarea id="instructions" name="instructions" rows="4" placeholder="Ajoutez des commentaires ou des demandes spécifiques"></textarea>
        </div>

        <!-- Soumettre la commande -->
        <button type="submit" class="btn-submit">Passer la commande</button>
      </form>
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
