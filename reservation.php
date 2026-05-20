<?php
require_once __DIR__ . '/init.php';
ensure_session();

$nom = $telephone = $email = $date = $heure = $instructions = '';
$nb_personnes = '';
$today = date('Y-m-d');
$message_success = '';
$message_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['name'] ?? '');
    $telephone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $heure = trim($_POST['time'] ?? '');
    $nb_personnes = (int) ($_POST['people'] ?? 0);
    $instructions = trim($_POST['instructions'] ?? '');

    $errors = [];
    if ($nom === '' || strlen($nom) < 2) $errors[] = 'Le nom doit contenir au moins 2 caracteres.';
    if ($telephone === '' || !preg_match('/^\+?[0-9]{8,}$/', str_replace(' ', '', $telephone))) $errors[] = "Le telephone n'est pas valide.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'adresse email n'est pas valide.";
    if ($date === '') $errors[] = 'La date est obligatoire.';
    elseif (strtotime($date) < strtotime(date('Y-m-d'))) $errors[] = 'La date ne peut pas etre dans le passe.';
    if ($heure === '') $errors[] = "L'heure est obligatoire.";
    if ($nb_personnes < 1 || $nb_personnes > 20) $errors[] = 'Le nombre de personnes doit etre entre 1 et 20.';

    if ($errors) {
        $message_error = implode('<br>', array_map('e', $errors));
    } else {
        try {
            save_reservation(compact('nom', 'email', 'telephone', 'date', 'heure', 'nb_personnes', 'instructions'));
            $message_success = 'Merci ! Votre reservation a ete enregistree.';
            $nom = $telephone = $email = $date = $heure = $nb_personnes = $instructions = '';
        } catch (Throwable $e) {
            $message_error = "Impossible d'enregistrer la reservation. Verifiez la base de donnees.";
        }
    }
}

render_page_head('Réservation');
render_header('reservation.php');
?>

  <section class="reservation-section">
    <div class="page-intro">
    <h1 class="reservation-title">Réservez une table</h1>
    <p class="reservation-description">Veuillez remplir le formulaire ci-dessous pour réserver votre place.</p>

    </div>
    <?php if ($message_success): ?>
      <div class="alert alert-success"><?php echo $message_success; ?></div>
    <?php endif; ?>
    <?php if ($message_error): ?>
      <div class="alert alert-error"><?php echo $message_error; ?></div>
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
<?php render_footer(); ?>
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
<?php render_footer(); ?>
