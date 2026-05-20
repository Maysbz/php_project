<?php
require_once __DIR__ . '/init.php';
ensure_session();

$nom = '';
$email = '';
$message = '';
$message_success = '';
$message_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if ($nom === '' || strlen($nom) < 2) {
        $errors[] = 'Le nom doit contenir au moins 2 caracteres.';
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    if ($message === '' || strlen($message) < 10) {
        $errors[] = 'Le message doit contenir au moins 10 caracteres.';
    }

    if ($errors) {
        $message_error = implode('<br>', array_map('e', $errors));
    } else {
        try {
            save_contact($nom, $email, $message);
            $message_success = 'Merci ! Votre message a ete envoye avec succes.';
            $nom = $email = $message = '';
        } catch (Throwable $e) {
            $message_error = "Impossible d'enregistrer le message. Verifiez la base de donnees.";
        }
    }
}

render_page_head('Contact');
render_header('contact.php');
?>

  <section class="contact-section">
    <div class="page-intro">
    <h1 class="contact-title">Contactez-nous</h1>
    <p class="contact-description">Pour toute question ou réservation, contactez-nous ou visitez notre restaurant.</p>
    </div>

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

      <div class="form-section">
          <h2>Contactez-nous </h2>
          <form method="POST" action="contact.php" id="contactForm">
              <label for="name">Nom:</label>
              <input type="text" id="name" name="name" placeholder="Votre nom" required value="<?php echo e($nom); ?>">
              <span class="error-message" id="nameError"></span>

              <label for="email">E-Mail:</label>
              <input type="email" id="email" name="email" placeholder="Votre email" required value="<?php echo e($email); ?>">
              <span class="error-message" id="emailError"></span>

              <label for="message">Message:</label>
              <textarea id="message" name="message" placeholder="Votre message" required><?php echo e($message); ?></textarea>
              <span class="error-message" id="messageError"></span>

              <button type="submit">Envoyer</button>
          </form>
      </div>
  </div>

    <div class="map-container">
      <iframe
        src="https://www.google.com/maps?q=Damascino+Lac+2+Tunis&output=embed"
        width="100%" height="400" style="border:0;"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>

  <script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      let isValid = true;
      document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
      const name = document.getElementById('name').value.trim();
      if (name.length < 2) {
        document.getElementById('nameError').textContent = 'Le nom doit contenir au moins 2 caractères.';
        isValid = false;
      }
      const email = document.getElementById('email').value.trim();
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        document.getElementById('emailError').textContent = 'Veuillez entrer une adresse email valide.';
        isValid = false;
      }
      const message = document.getElementById('message').value.trim();
      if (message.length < 10) {
        document.getElementById('messageError').textContent = 'Le message doit contenir au moins 10 caractères.';
        isValid = false;
      }
      if (!isValid) e.preventDefault();
    });
  </script>
<?php render_footer(); ?>