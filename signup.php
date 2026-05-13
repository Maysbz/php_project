<?php
session_start();

// Si déjà connecté, rediriger vers l'accueil
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$errors  = [];
$success = false;

// Simulation d'une "base de données" avec un fichier JSON
// (à remplacer par une vraie base MySQL plus tard)
$users_file = 'users.json';

// Charger les utilisateurs existants
$users = [];
if (file_exists($users_file)) {
    $users = json_decode(file_get_contents($users_file), true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username         = htmlspecialchars(trim($_POST['username']));
    $email            = htmlspecialchars(trim($_POST['email']));
    $phone            = htmlspecialchars(trim($_POST['phone']));
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];

    // --- Validations ---

    // Nom d'utilisateur
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    } elseif (strlen($username) < 3) {
        $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
    }

    // Email
    if (empty($email)) {
        $errors[] = "L'adresse email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    } else {
        // Vérifier si l'email existe déjà
        foreach ($users as $u) {
            if ($u['email'] === $email) {
                $errors[] = "Cette adresse email est déjà utilisée.";
                break;
            }
        }
    }

    // Téléphone
    if (empty($phone)) {
        $errors[] = "Le numéro de téléphone est obligatoire.";
    } elseif (!preg_match('/^[0-9]{8}$/', $phone)) {
        $errors[] = "Le numéro de téléphone doit contenir exactement 8 chiffres.";
    }

    // Mot de passe
    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // Confirmation mot de passe
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // --- Si pas d'erreurs : enregistrer l'utilisateur ---
    if (empty($errors)) {
        $new_user = [
            'username' => $username,
            'email'    => $email,
            'phone'    => $phone,
            'password' => password_hash($password, PASSWORD_DEFAULT), // mot de passe hashé
            'created'  => date('Y-m-d H:i:s')
        ];

        $users[] = $new_user;
        file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));

        // Connecter automatiquement après inscription
        $_SESSION['user']     = $email;
        $_SESSION['username'] = $username;

        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Inscription</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .error-box {
      background: #f8d7da;
      border: 1px solid #f5c6cb;
      color: #721c24;
      padding: 15px 20px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .error-box ul {
      margin: 8px 0 0 18px;
      padding: 0;
    }
    .error-box ul li { margin-bottom: 4px; }

    .success-box {
      background: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724;
      padding: 25px;
      border-radius: 8px;
      text-align: center;
      max-width: 500px;
      margin: 40px auto;
    }
    .success-box h2 { margin-bottom: 10px; }

    .password-wrapper {
      position: relative;
    }
    .password-wrapper input {
      width: 100%;
      padding-right: 45px;
      box-sizing: border-box;
    }
    .toggle-password {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 1.1rem;
      background: none;
      border: none;
      color: #8B0000;
    }
    .password-strength {
      height: 6px;
      border-radius: 3px;
      margin-top: 6px;
      transition: all 0.3s;
      background: #ddd;
    }
    .strength-text {
      font-size: 0.8rem;
      margin-top: 3px;
    }
  </style>
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

  <section class="signup-section">
    <h1 class="signup-title">Créer un compte</h1>
    <p class="signup-description">Rejoignez la famille Damascino pour profiter de nos offres exclusives !</p>

    <?php if ($success): ?>
      <!-- Message de succès -->
      <div class="success-box">
        <h2>🎉 Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h2>
        <p>Votre compte a été créé avec succès. Vous êtes maintenant connecté.</p>
        <br>
        <a href="index.php" class="btn-submit" style="display:inline-block; margin-right:10px;">🏠 Accueil</a>
        <a href="reservation.php" class="btn-submit" style="display:inline-block;">📅 Réserver une table</a>
      </div>

    <?php else: ?>

      <div class="signup-form-container">

        <!-- Affichage des erreurs -->
        <?php if (!empty($errors)): ?>
          <div class="error-box">
            <strong>⚠️ Veuillez corriger les erreurs suivantes :</strong>
            <ul>
              <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form class="signup-form" action="signup.php" method="POST">

          <div class="form-group">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username"
                   value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>"
                   placeholder="Votre nom d'utilisateur" required>
          </div>

          <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email"
                   value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                   placeholder="Votre adresse email" required>
          </div>

          <div class="form-group">
            <label for="phone">Numéro de téléphone :</label>
            <input type="tel" id="phone" name="phone"
                   value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"
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
          <p class="login-link">Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
        </form>
      </div>

    <?php endif; ?>
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
          <a href="https://www.facebook.com/damascino.orientalfood" class="social-icon"><img src="images/facebook.png" alt="Facebook"></a>
          <a href="https://www.instagram.com/damascino.orientalfood/" class="social-icon"><img src="images/insta.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2023 damascino. Tous droits réservés.</p>
    </div>
  </footer>

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
  </script>

</body>
</html>
