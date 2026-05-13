<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Contactez-nous</title>
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
          <li><a href="login.php" class="Connexion">Connexion</a></li>
        </ul>
    </nav>
  </header>

  <section class="contact-section">
    <h1 class="contact-title">Contactez-nous</h1>
    <p class="contact-description">Pour toute question ou réservation, contactez-nous ou visitez notre restaurant à l'adresse ci-dessous.</p>
    <!-- info-section-->

    <div class="container">
      <div class="info-section">
          <h2> Comment nous trouver </h2>
          <p>Nous sommes situés au berges du lac 2 ,menzah 5 . Utilisez notre carte pour trouver le restaurant le plus proche.</p>
          Address: Rue de la Feuille d'Érable, Tunis 1053<br>
          Telephone:  +216 53 888 880<br>
          E-mail: contact@damascino.tn</p>
      </div>

        <!-- contact form-->
      <div class="form-section">
          <h2>Contactez-nous </h2>
          <form>
              <label for="name">Name:</label>
              <input type="text" id="name" name="name" placeholder="Your name" required>

              <label for="email">E-Mail:</label>
              <input type="email" id="email" name="email" placeholder="Your email" required>

              <label for="message">Message:</label>
              <textarea id="message" name="message" placeholder="Your message" required></textarea>

              <button type="submit">Send</button>
          </form>
      </div>
  </div>


    <!-- Carte Google Maps sous les informations de contact -->
    <div class="map-container">
      <iframe 
        src="https://www.google.com/maps?q=Damascino+Lac+2+Tunis&output=embed" 
        width="100%" 
        height="400" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
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
