<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Inscription</title>
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

  <section class="signup-section">
    <h1 class="signup-title">Créer un compte</h1>
    <p class="signup-description">Veuillez remplir le formulaire pour créer un compte sur notre restaurant.</p>

    <div class="signup-form-container">
      <form class="signup-form" action="login.html" method="POST">
        <div class="form-group">
          <label for="username">Nom d'utilisateur :</label>
          <input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur" required>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" placeholder="Votre adresse email" required>
        </div>
        <div class="form-group">
          <label for="phone">numero de tele :</label>
          <input type="tel" id="phone" name="phone" placeholder="Votre numero de telephone" pattern="[0-9]{8}" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
        </div>
        <div class="form-group">
          <label for="confirm_password">Confirmer le mot de passe :</label>
          <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirmer votre mot de passe" required>
        </div>
        <button type="submit" class="btn-signup">S'inscrire</button>
        <p class="login-link">Vous avez déjà un compte ? <a href="login.html">Se connecter</a></p>
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
