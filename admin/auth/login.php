<?php
require_once __DIR__ . '/../../init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handle_login_post();
}

ensure_session();
if (isset($_SESSION['user'])) {
    redirect(auth_home_url());
}
$errors = $_SESSION['login_errors'] ?? [];
$saved_email = $_SESSION['login_email'] ?? '';
unset($_SESSION['login_errors'], $_SESSION['login_email']);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Connexion</title>
  <link rel="stylesheet" href="<?php echo e(versioned_asset_href('../../style.css')); ?>">
</head>
<body>
  <header class="main-header">
    <div class="logo">damascino</div>
  </header>

  <section class="login-section">
    <h1 class="login-title">Connexion Admin</h1>
    <p class="login-description">Veuillez entrer vos identifiants administrateur.</p>

    <div class="login-form-container">

      <?php if (!empty($errors)): ?>
        <div class="error-box">
          <strong>⚠️ Erreur de connexion :</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="login-form" action="<?php echo e(admin_url('auth/login.php')); ?>" method="POST" id="loginForm">

        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email"
                 value="<?php echo e($saved_email); ?>"
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
      </form>
    </div>
  </section>

  <footer class="main-footer">
    <div class="footer-container">
      <div class="footer-section about">
        <h3>À propos de nous</h3>
        <p>Damascino vous invite à un voyage culinaire au cœur de la Syrie, où l'authenticité des saveurs levantines rencontre la générosité d'un accueil chaleureux.</p>
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

    document.getElementById('loginForm').addEventListener('submit', function (e) {
      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value;
      if (!email || !password) {
        e.preventDefault();
        alert('Veuillez remplir email et mot de passe.');
      }
    });
  </script>

</body>
</html>
