<?php
session_start();

// Si déjà connecté, rediriger vers l'accueil
if (isset($_SESSION['user'])) {
    header("Location: index.html");
    exit();
}

// Récupérer les erreurs et l'email depuis la session
$errors      = $_SESSION['login_errors'] ?? [];
$saved_email = $_SESSION['login_email']  ?? '';

// Nettoyer après récupération
unset($_SESSION['login_errors'], $_SESSION['login_email']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Connexion</title>
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
        <li><a href="contact.php">Contact</a></li>
        <li><a href="reservation.php">Réservation</a></li>
        <li><a href="discount.html">Offres</a></li>
        <li><a href="login.php" class="Connexion">Connexion</a></li>
      </ul>
    </nav>
  </header>

  <section class="login-section">
    <h1 class="login-title">Se connecter</h1>
    <p class="login-description">Veuillez entrer vos informations pour accéder à votre compte.</p>

    <div class="login-form-container">

      <!-- Affichage des erreurs -->
      <?php if (!empty($errors)): ?>
        <div class="error-box">
          <strong>⚠️ Erreur de connexion :</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="login-form" action="login_action.php" method="POST">

        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email"
                 value="<?php echo htmlspecialchars($saved_email); ?>"
                 placeholder="Votre adresse email" required>
        </div>

        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password"
                   placeholder="Votre mot de passe" required>
            <button type="button" class="toggle-password" onclick="togglePassword()">👁️</button>
          </div>
        </div>

        <button type="submit" class="btn-login">Se connecter</button>
        <p class="signup-link">Pas encore de compte ? <a href="signup.php">S'inscrire</a></p>
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

  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>

</body>
</html>
