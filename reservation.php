<?php
include 'db.php';

$message_success = '';
$message_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et valider les données
    $nom = trim($_POST['name'] ?? '');
    $telephone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $heure = trim($_POST['time'] ?? '');
    $nb_personnes = intval($_POST['people'] ?? 0);
    $instructions = trim($_POST['instructions'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($nom) || strlen($nom) < 2) {
        $errors[] = "Le nom doit contenir au moins 2 caractères.";
    }
    if (empty($telephone) || !preg_match('/^\+?[0-9]{8,}$/', str_replace(' ', '', $telephone))) {
        $errors[] = "Le téléphone n'est pas valide.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    if (empty($date)) {
        $errors[] = "La date est obligatoire.";
    } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
        $errors[] = "La date ne peut pas être dans le passé.";
    }
    if (empty($heure)) {
        $errors[] = "L'heure est obligatoire.";
    }
    if ($nb_personnes < 1 || $nb_personnes > 20) {
        $errors[] = "Le nombre de personnes doit être entre 1 et 20.";
    }
    
    // Si pas d'erreur, insérer dans la BDD
    if (empty($errors)) {
        $nom_escaped = mysqli_real_escape_string($conn, $nom);
        $telephone_escaped = mysqli_real_escape_string($conn, $telephone);
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $instructions_escaped = mysqli_real_escape_string($conn, $instructions);
        
        $insert_query = "INSERT INTO reservation_table (nom, email, telephone, date_reservation, heure_reservation, nb_personnes, instructions) 
                        VALUES ('$nom_escaped', '$email_escaped', '$telephone_escaped', '$date', '$heure', $nb_personnes, '$instructions_escaped')";
        
        if (mysqli_query($conn, $insert_query)) {
            $message_success = "Merci ! Votre réservation a été enregistrée. Nous vous confirmerons sous peu.";
            // Réinitialiser le formulaire
            $nom = $telephone = $email = $date = $heure = $nb_personnes = $instructions = '';
        } else {
            $message_error = "Une erreur s'est produite. Veuillez réessayer.";
        }
    } else {
        $message_error = implode("<br>", $errors);
    }
}

// Définir la date minimale à aujourd'hui
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant - Réservation</title>
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
          <li><a href="login.php"  class="Connexion">Connexion</a></li>
        </ul>
    </nav>
</header>

  <section class="reservation-section">
    <h1 class="reservation-title">Réservez une table</h1>
    <p class="reservation-description">Veuillez remplir le formulaire ci-dessous pour réserver votre place.</p>

    <?php if ($message_success): ?>
      <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin: 20px auto; max-width: 600px;">
        <?php echo $message_success; ?>
      </div>
    <?php endif; ?>
    
    <?php if ($message_error): ?>
      <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px auto; max-width: 600px;">
        <?php echo $message_error; ?>
      </div>
    <?php endif; ?>

    <div class="reservation-form-container">
      <form class="reservation-form" action="reservation.php" method="POST" id="reservationForm">
        <!-- Informations personnelles -->
        <div class="form-group">
          <label for="name">Nom :</label>
          <input type="text" id="name" name="name" placeholder="Votre nom" required value="<?php echo htmlspecialchars($nom ?? ''); ?>">
          <span class="error-message" id="nameError"></span>
        </div>
        <div class="form-group">
          <label for="phone">Téléphone :</label>
          <input type="tel" id="phone" name="phone" placeholder="Votre numéro de téléphone" required value="<?php echo htmlspecialchars($telephone ?? ''); ?>">
          <span class="error-message" id="phoneError"></span>
        </div>
        <div class="form-group">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" placeholder="Votre adresse email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
          <span class="error-message" id="emailError"></span>
        </div>

        <!-- Détails de la réservation -->
        <div class="form-group">
          <label for="date">Date :</label>
          <input type="date" id="date" name="date" required min="<?php echo $today; ?>" value="<?php echo htmlspecialchars($date ?? ''); ?>">
          <span class="error-message" id="dateError"></span>
        </div>
        <div class="form-group">
          <label for="time">Heure :</label>
          <input type="time" id="time" name="time" required value="<?php echo htmlspecialchars($heure ?? ''); ?>">
          <span class="error-message" id="timeError"></span>
        </div>
        <div class="form-group">
          <label for="people">Nombre de personnes :</label>
          <input type="number" id="people" name="people" min="1" max="20" placeholder="min 1 a max 20" required value="<?php echo htmlspecialchars($nb_personnes ?? ''); ?>">
          <span class="error-message" id="peopleError"></span>
        </div>

        <!-- Instructions spéciales -->
        <div class="form-group">
          <label for="instructions">Instructions spéciales :</label>
          <textarea id="instructions" name="instructions" rows="4" placeholder="Ajoutez des demandes spécifiques ou préférences"><?php echo htmlspecialchars($instructions ?? ''); ?></textarea>
        </div>

        <!-- Soumettre la réservation -->
        <button type="submit" class="btn-submit">Réserver maintenant</button>
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
    // Bloquer les dates passées
    const dateInput = document.getElementById('date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
    
    // Validation du formulaire réservation
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
      let isValid = true;
      
      // Réinitialiser les erreurs
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
      
      // Valider le nom
      const name = document.getElementById('name').value.trim();
      if (name.length < 2) {
        document.getElementById('nameError').textContent = 'Le nom doit contenir au moins 2 caractères.';
        isValid = false;
      }
      
      // Valider le téléphone
      const phone = document.getElementById('phone').value.trim();
      const phoneRegex = /^\+?[0-9]{8,}$/;
      if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
        document.getElementById('phoneError').textContent = 'Veuillez entrer un numéro de téléphone valide.';
        isValid = false;
      }
      
      // Valider l'email
      const email = document.getElementById('email').value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Veuillez entrer une adresse email valide.';
        isValid = false;
      }
      
      // Valider la date
      const date = new Date(document.getElementById('date').value);
      const todayDate = new Date();
      todayDate.setHours(0, 0, 0, 0);
      if (date < todayDate) {
        document.getElementById('dateError').textContent = 'La date ne peut pas être dans le passé.';
        isValid = false;
      }
      
      // Valider le nombre de personnes
      const people = parseInt(document.getElementById('people').value);
      if (people < 1 || people > 20) {
        document.getElementById('peopleError').textContent = 'Le nombre doit être entre 1 et 20.';
        isValid = false;
      }
      
      if (!isValid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
