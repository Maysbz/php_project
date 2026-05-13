<?php
session_start();

// Rediriger vers login si non connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
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
        <li><a href="index.php">Accueil</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="about.php">À propos</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="reservation.php">Réservation</a></li>
        <li><a href="discount.php">Offres</a></li>
        <li><a href="logout.php" class="Connexion">Déconnexion</a></li>
      </ul>
    </nav>
  </header>

  <section class="order-section">
    <h1 class="order-title">Passer une commande</h1>
    <p class="order-description">Remplissez le formulaire ci-dessous pour commander vos plats préférés. Nous préparerons votre commande dès que possible !</p>

    <div class="order-form-container">
      <form class="order-form" action="facture.php" method="POST">

        <!-- Informations personnelles -->
        <div class="form-group">
          <label for="name">Nom :</label>
          <input type="text" id="name" name="name" placeholder="Votre nom" required>
        </div>
        <div class="form-group">
          <label for="telephone">Téléphone :</label>
          <input type="tel" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" required>
        </div>
        <div class="form-group">
          <label for="address">Adresse :</label>
          <input type="text" id="address" name="address" placeholder="Votre adresse complète" required>
        </div>

        <!-- Sélection des plats -->
        <h2 class="section-subtitle">Choisissez vos plats :</h2>

        <div class="menu-options">

          <!-- Entrées -->
          <h3 style="margin-top:15px; color:#8B0000;">🥗 Entrées</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish1" name="plats[]" value="Soupe aux lentilles|15">
            <label for="dish1">Soupe aux lentilles — 15 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish2" name="plats[]" value="Fattouch|10">
            <label for="dish2">Fattouch — 10 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish3" name="plats[]" value="Maza|20">
            <label for="dish3">Maza — 20 TND</label>
          </div>

          <!-- Plats principaux -->
          <h3 style="margin-top:15px; color:#8B0000;">🍖 Plats principaux</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish4" name="plats[]" value="Kebab mixte|80">
            <label for="dish4">Kebab mixte — 80 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish5" name="plats[]" value="Mandi poulet|40">
            <label for="dish5">Mandi poulet — 40 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish6" name="plats[]" value="Majouka|30">
            <label for="dish6">Majouka — 30 TND</label>
          </div>

          <!-- Desserts -->
          <h3 style="margin-top:15px; color:#8B0000;">🍮 Desserts</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish7" name="plats[]" value="Tiramisu|10">
            <label for="dish7">Tiramisu — 10 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish8" name="plats[]" value="Kunefa|30">
            <label for="dish8">Kunefa — 30 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish9" name="plats[]" value="Layali lebnan|15">
            <label for="dish9">Layali lebnan — 15 TND</label>
          </div>

          <!-- Boissons -->
          <h3 style="margin-top:15px; color:#8B0000;">🥤 Boissons</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish10" name="plats[]" value="Citronnade|9">
            <label for="dish10">Citronnade — 9 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish11" name="plats[]" value="Thé à la Menthe|12">
            <label for="dish11">Thé à la Menthe — 12 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish12" name="plats[]" value="Ayrane|10">
            <label for="dish12">Ayrane — 10 TND</label>
          </div>

          <!-- Spécialités -->
          <h3 style="margin-top:15px; color:#8B0000;">⭐ Spécialités</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish13" name="plats[]" value="Sambousek|15">
            <label for="dish13">Sambousek — 15 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish14" name="plats[]" value="Warak enab|20">
            <label for="dish14">Warak enab — 20 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish15" name="plats[]" value="Kebba|10">
            <label for="dish15">Kebba — 10 TND</label>
          </div>

        </div>

        <!-- Total en temps réel (JavaScript) -->
        <div class="invoice-summary" style="margin-top:20px;">
          <p><strong>Total estimé : <span id="total">0</span> TND</strong></p>
        </div>

        <!-- Instructions spéciales -->
        <div class="form-group">
          <label for="instructions">Instructions spéciales :</label>
          <textarea id="instructions" name="instructions" rows="4" placeholder="Ajoutez des commentaires ou des demandes spécifiques"></textarea>
        </div>

        <!-- Soumettre -->
        <button type="submit" class="btn-submit">Passer la commande</button>
      </form>
    </div>
  </section>

  <footer class="main-footer">
    <div class="footer-container">
      <div class="footer-section about">
        <h3>À propos de nous</h3>
        <p>Damascino vous invite à un voyage culinaire au cœur de la Syrie, où l'authenticité des saveurs levantines rencontre la générosité d'un accueil chaleureux.</p>
      </div>
      <div class="footer-section contact">
        <h3>Contactez-nous</h3>
        <p><strong>Adresse :</strong> Rue de la Feuille d'Érable, Tunis 1053</p>
        <p><strong>Téléphone :</strong> +216 53 888 880</p>
        <p><strong>Email :</strong> contact@damascino.tn</p>
      </div>
      <div class="footer-section hours">
        <h3>Horaires d'ouverture</h3>
        <ul>
          <li>Lundi - Vendredi : 11h - 23h</li>
          <li>Samedi - Dimanche : 11h - 00h</li>
        </ul>
      </div>
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

  <!-- JavaScript : calcul du total en temps réel + validation -->
  <script>
    // Calcul du total en temps réel
    const checkboxes = document.querySelectorAll('input[name="plats[]"]');
    const totalSpan  = document.getElementById('total');

    checkboxes.forEach(cb => {
      cb.addEventListener('change', () => {
        let total = 0;
        checkboxes.forEach(c => {
          if (c.checked) {
            const prix = parseInt(c.value.split('|')[1]);
            total += prix;
          }
        });
        totalSpan.textContent = total;
      });
    });

    // Validation : vérifier qu'un plat est coché avant d'envoyer
    document.querySelector('.order-form').addEventListener('submit', function(e) {
      const unPlatCoche = Array.from(checkboxes).some(c => c.checked);

      if (!unPlatCoche) {
        e.preventDefault(); // Bloque l'envoi du formulaire
        alert('⚠️ Veuillez sélectionner au moins un plat avant de passer la commande !');
      }
    });
  </script>

</body>
</html>