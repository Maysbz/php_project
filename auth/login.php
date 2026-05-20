<?php
require_once __DIR__ . '/../init.php';

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

render_page_head('Connexion');
render_header('');
?>

  <section class="login-section">
    <h1 class="login-title">Se connecter</h1>
    <p class="login-description">Accédez à votre compte Damascino.</p>

    <div class="login-form-container">
      <?php if (!empty($errors)): ?>
        <div class="error-box">
          <strong>Erreur de connexion</strong>
          <ul>
            <?php foreach ($errors as $error): ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form class="login-form" action="<?php echo e(page_url('auth/login.php')); ?>" method="POST" id="loginForm">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="<?php echo e($saved_email); ?>" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe</label>
          <div class="password-wrapper">
            <input type="password" id="password" name="password" required>
            <button type="button" class="toggle-password" aria-label="Afficher">👁</button>
          </div>
        </div>
        <button type="submit" class="btn-login">Se connecter</button>
        <p class="signup-link">Pas encore de compte ? <a href="<?php echo e(page_url('auth/signup.php')); ?>">S'inscrire</a></p>
      </form>
    </div>
  </section>

  <script>
    document.querySelector('.toggle-password')?.addEventListener('click', function () {
      const input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';
    });
  </script>
<?php render_footer(); ?>
