<?php
require_once __DIR__ . '/../init.php';
ensure_session();

if (isset($_SESSION['user'])) {
    redirect(page_url('index.php'));
}

$errors = [];
$success = false;
$username = '';
$email = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmpassword'] ?? '';

    if ($username === '') {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    } elseif (strlen($username) < 3) {
        $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caracteres.";
    }
    if ($email === '') {
        $errors[] = "L'adresse email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    } else {
        try {
            if (user_find_by_email($email)) {
                $errors[] = 'Cette adresse email est deja utilisee.';
            }
        } catch (Throwable $e) {
            $errors[] = 'Base de donnees indisponible.';
        }
    }
    if ($phone === '') {
        $errors[] = 'Le numero de telephone est obligatoire.';
    } elseif (!preg_match('/^[0-9]{8}$/', $phone)) {
        $errors[] = 'Le numero de telephone doit contenir exactement 8 chiffres.';
    }
    if ($password === '') {
        $errors[] = 'Le mot de passe est obligatoire.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Le mot de passe doit contenir au moins 6 caracteres.';
    }
    if ($password !== $confirmPassword) {
        $errors[] = 'Les mots de passe ne correspondent pas.';
    }

    if (!$errors) {
        try {
            $created = user_create($username, $email, $phone, $password);
            $_SESSION['user'] = $created['user']['email'];
            $_SESSION['username'] = $created['user']['username'];
            $_SESSION['user_id'] = $created['id'];
            $_SESSION['role'] = $created['user']['role'] ?? 'client';
            $success = true;
        } catch (Throwable $e) {
            $errors[] = "Impossible de creer le compte.";
        }
    }
}

render_page_head('Inscription');
render_header('');
?>

  <section class="signup-section">
    <h1 class="signup-title">Créer un compte</h1>
    <p class="signup-description">Rejoignez la famille Damascino pour profiter de nos offres exclusives !</p>

    <?php if ($success): ?>
      <!-- Message de succès -->
      <div class="success-box">
        <h2>Bienvenue, <?php echo e($_SESSION['username']); ?> !</h2>
        <p>Votre compte a été créé avec succès. Vous êtes maintenant connecté.</p>
        <br>
        <a href="<?php echo e(page_url('index.php')); ?>" class="btn-submit" style="display:inline-block; margin-right:10px;">🏠 Accueil</a>
        <a href="<?php echo e(page_url('reservation.php')); ?>" class="btn-submit" style="display:inline-block;">📅 Réserver une table</a>
      </div>

    <?php else: ?>

      <div class="signup-form-container">

        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)): ?>
          <div class="error-box">
            <strong>⚠️ Veuillez corriger les erreurs suivantes :</strong>
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form class="signup-form" action="<?php echo e(page_url('auth/signup.php')); ?>" method="POST" id="signupForm">

          <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username"
                   value="<?php echo isset($username) ? e($username) : ''; ?>"
                   placeholder="Votre nom d'utilisateur" required>
          </div>

          <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email"
                   value="<?php echo isset($email) ? e($email) : ''; ?>"
                   placeholder="Votre adresse email" required>
          </div>

          <div class="form-group">
            <label for="phone">Numéro de téléphone :</label>
            <input type="tel" id="phone" name="phone"
                   value="<?php echo isset($phone) ? e($phone) : ''; ?>"
                   placeholder="8 chiffres (ex: 52123456)" pattern="[0-9]{8}" required>
          </div>

          <div class="form-group">
            <label for="password">Mot de passe :</label>
            <div class="password-wrapper">
              <input type="password" id="password" name="password"
                     placeholder="Minimum 6 caractères" required>
              <button type="button" class="toggle-password" onclick="togglePassword('password')">👁️</button>
            </div>
            <div class="password-strength" id="strength-bar"></div>
            <div class="strength-text" id="strength-text"></div>
          </div>

          <div class="form-group">
            <label for="confirmpassword">Confirmer le mot de passe :</label>
            <div class="password-wrapper">
              <input type="password" id="confirmpassword" name="confirmpassword"
                     placeholder="Répétez votre mot de passe" required>
              <button type="button" class="toggle-password" onclick="togglePassword('confirmpassword')">👁️</button>
            </div>
            <div class="strength-text" id="match-text"></div>
          </div>

          <button type="submit" class="btn-signup">S'inscrire</button>
          <p class="login-link">Vous avez déjà un compte ? <a href="<?php echo e(page_url('auth/login.php')); ?>">Se connecter</a></p>
        </form>
      </div>

    <?php endif; ?>
  </section>

  <script>
    // Afficher / masquer le mot de passe
    function togglePassword(id) {
      const input = document.getElementById(id);
      input.type = input.type === 'password' ? 'text' : 'password';
    }

    // Indicateur de force du mot de passe
    document.getElementById('password').addEventListener('input', function () {
      const val = this.value;
      const bar  = document.getElementById('strength-bar');
      const text = document.getElementById('strength-text');

      let strength = 0;
      if (val.length >= 6)                       strength++;
      if (val.length >= 10)                      strength++;
      if (/[A-Z]/.test(val))                     strength++;
      if (/[0-9]/.test(val))                     strength++;
      if (/[^A-Za-z0-9]/.test(val))             strength++;

      const levels = [
        { color: '#e74c3c', label: 'Très faible' },
        { color: '#e67e22', label: 'Faible' },
        { color: '#f1c40f', label: 'Moyen' },
        { color: '#2ecc71', label: 'Fort' },
        { color: '#27ae60', label: 'Très fort' },
      ];

      const level = levels[Math.min(strength, 4)];
      bar.style.background = level.color;
      bar.style.width = ((strength / 5) * 100) + '%';
      text.textContent = val.length ? '🔒 ' + level.label : '';
      text.style.color = level.color;
    });

    // Vérification de correspondance des mots de passe
    document.getElementById('confirmpassword').addEventListener('input', function () {
      const pass    = document.getElementById('password').value;
      const matchEl = document.getElementById('match-text');
      if (this.value === '') {
        matchEl.textContent = '';
      } else if (this.value === pass) {
        matchEl.textContent = '✅ Les mots de passe correspondent';
        matchEl.style.color = '#27ae60';
      } else {
        matchEl.textContent = '❌ Les mots de passe ne correspondent pas';
        matchEl.style.color = '#e74c3c';
      }
    });

    document.getElementById('signupForm')?.addEventListener('submit', function (e) {
      const phone = document.getElementById('phone').value.trim();
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirmpassword').value;

      if (!/^[0-9]{8}$/.test(phone)) {
        e.preventDefault();
        alert('Le telephone doit contenir exactement 8 chiffres.');
        return;
      }

      if (password.length < 6) {
        e.preventDefault();
        alert('Le mot de passe doit contenir au moins 6 caracteres.');
        return;
      }

      if (password !== confirmPassword) {
        e.preventDefault();
        alert('Les mots de passe ne correspondent pas.');
      }
    });
  </script>
<?php render_footer(); ?>
