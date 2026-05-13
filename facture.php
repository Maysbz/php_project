<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Facture</title>
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
<!-- Informations du Facture -->
  <section class="invoice-section">
    <div class="invoice-container">
      <h1 class="invoice-title">Facture</h1>
      <p class="invoice-number">Numéro de facture : #00123</p>
      <p class="invoice-date">Date : 07 janvier 2025</p>

      <!-- Informations du client -->
      <div class="customer-info">
        <p><strong>Nom du client :</strong> Ahmed Ben Ahmed</p>
        <p><strong>Adresse :</strong> 1 Rue du Ghana, 2080 Ariana</p>
        <p><strong>Téléphone :</strong> +216 12 345 679</p>
      </div>

      <!-- Détails de la commande -->
      <table class="invoice-table">
        <thead>
          <tr>
            <th>Article</th>
            <th>Quantité</th>
            <th>Prix Unitaire</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Pizza Margherita</td>
            <td>2</td>
            <td>10DT</td>
            <td>20DT</td>
          </tr>
          <tr>
            <td>Filet de Saumon</td>
            <td>1</td>
            <td>54DT</td>
            <td>54DT</td>
          </tr>
          <tr>
            <td>Salade César</td>
            <td>1</td>
            <td>30DT</td>
            <td>30DT</td>
          </tr>
        </tbody>
      </table>

      <!-- Total -->
      <div class="invoice-summary">
        <p><strong>Sous-total :</strong> 104DT</p>
        <p><strong>TVA (10%) :</strong> 10,4DT</p>
        <p><strong>Total :</strong> 114,4DT</p>
      </div>

      <p class="thank-you">Merci pour votre commande !</p>
      <button class="btn-submit">Télécharger la facture en PDF</button>

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
