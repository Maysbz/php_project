<?php
include 'db.php';

$message_success = '';
$message_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et valider les données
    $nom = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Validation
    $errors = [];
    if (empty($nom) || strlen($nom) < 2) {
        $errors[] = "Le nom doit contenir au moins 2 caractères.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Le message doit contenir au moins 10 caractères.";
    }
    
    // Si pas d'erreur, insérer dans la BDD
    if (empty($errors)) {
        $nom_escaped = mysqli_real_escape_string($conn, $nom);
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $message_escaped = mysqli_real_escape_string($conn, $message);
        
        $insert_query = "INSERT INTO contact (nom, email, message) VALUES ('$nom_escaped', '$email_escaped', '$message_escaped')";
        
        if (mysqli_query($conn, $insert_query)) {
            $message_success = "Merci ! Votre message a été envoyé avec succès. Nous vous répondrons bientôt.";
            // Réinitialiser le formulaire
            $nom = $email = $message = '';
        } else {
            $message_error = "Une erreur s'est produite. Veuillez réessayer.";
        }
    } else {
        $message_error = implode("<br>", $errors);
    }
}
?>
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
    
    <?php if ($message_success): ?>
      <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin: 20px 0;">
        <?php echo $message_success; ?>
      </div>
    <?php endif; ?>
    
    <?php if ($message_error): ?>
      <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin: 20px 0;">
        <?php echo $message_error; ?>
      </div>
    <?php endif; ?>

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
          <form method="POST" action="contact.php" id="contactForm">
              <label for="name">Nom:</label>
              <input type="text" id="name" name="name" placeholder="Votre nom" required value="<?php echo htmlspecialchars($nom ?? ''); ?>">
              <span class="error-message" id="nameError"></span>

              <label for="email">E-Mail:</label>
              <input type="email" id="email" name="email" placeholder="Votre email" required value="<?php echo htmlspecialchars($email ?? ''); ?>">
              <span class="error-message" id="emailError"></span>

              <label for="message">Message:</label>
              <textarea id="message" name="message" placeholder="Votre message" required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
              <span class="error-message" id="messageError"></span>

              <button type="submit">Envoyer</button>
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

  <script>
    // Validation du formulaire contact
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      let isValid = true;
      
      // Réinitialiser les erreurs
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
      
      // Valider le nom
      const name = document.getElementById('name').value.trim();
      if (name.length < 2) {
        document.getElementById('nameError').textContent = 'Le nom doit contenir au moins 2 caractères.';
        isValid = false;
      }
      
      // Valider l'email
      const email = document.getElementById('email').value.trim();
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById('emailError').textContent = 'Veuillez entrer une adresse email valide.';
        isValid = false;
      }
      
      // Valider le message
      const message = document.getElementById('message').value.trim();
      if (message.length < 10) {
        document.getElementById('messageError').textContent = 'Le message doit contenir au moins 10 caractères.';
        isValid = false;
      }
      
      if (!isValid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
