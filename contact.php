<?php
include("db.php");

if(isset($_POST['submit'])) {

    $nom = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact(nom, email, message)
            VALUES('$nom', '$email', '$message')";

    if(mysqli_query($conn, $sql)) {

        echo "<script>
                alert('Message envoyé avec succès');
              </script>";

    } else {

        echo "Erreur : " . mysqli_error($conn);

    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Restaurant - Contactez-nous</title>

  <link rel="stylesheet" href="style.css">

</head>

<body>

<!-- HEADER -->

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

          <li>
            <a href="login.php" class="Connexion">
              Connexion
            </a>
          </li>

        </ul>

    </nav>

</header>

<!-- CONTACT SECTION -->

<section class="contact-section">

    <h1 class="contact-title">
      Contactez-nous
    </h1>

    <p class="contact-description">

      Pour toute question ou réservation,
      contactez-nous ou visitez notre restaurant.

    </p>

    <div class="container">

      <!-- INFO -->

      <div class="info-section">

          <h2>Comment nous trouver</h2>

          <p>
            Nous sommes situés aux Berges du Lac 2,
            Tunis.
          </p>

          <p>
            <strong>Adresse :</strong>
            Rue de la Feuille d'Érable, Tunis 1053
          </p>

          <p>
            <strong>Téléphone :</strong>
            +216 53 888 880
          </p>

          <p>
            <strong>Email :</strong>
            contact@damascino.tn
          </p>

      </div>

      <!-- FORM -->

      <div class="form-section">

          <h2>Envoyer un message</h2>

          <form
            method="POST"
            action=""
            onsubmit="return validateContact()"
          >

              <!-- NOM -->

              <label for="name">
                Nom :
              </label>

              <input
                type="text"
                id="name"
                name="name"
                placeholder="Votre nom"
                required
              >

              <!-- EMAIL -->

              <label for="email">
                Email :
              </label>

              <input
                type="email"
                id="email"
                name="email"
                placeholder="Votre email"
                required
              >

              <!-- MESSAGE -->

              <label for="message">
                Message :
              </label>

              <textarea
                id="message"
                name="message"
                placeholder="Votre message"
                required
              ></textarea>

              <!-- BUTTON -->

              <button
                type="submit"
                name="submit"
              >
                Envoyer
              </button>

          </form>

      </div>

    </div>

    <!-- GOOGLE MAP -->

    <div class="map-container">

      <iframe
        src="https://www.google.com/maps?q=Damascino+Lac+2+Tunis&output=embed"
        width="100%"
        height="400"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
      >
      </iframe>

    </div>

</section>

<!-- FOOTER -->

<footer class="main-footer">

    <div class="footer-container">

      <!-- ABOUT -->

      <div class="footer-section about">

        <h3>À propos de nous</h3>

        <p>
          Damascino vous invite à un voyage culinaire
          au cœur de la Syrie, où l'authenticité des
          saveurs levantines rencontre la générosité
          d'un accueil chaleureux.
        </p>

      </div>

      <!-- CONTACT -->

      <div class="footer-section contact">

        <h3>Contactez-nous</h3>

        <p>
          <strong>Adresse :</strong>
          Rue de la Feuille d'Érable, Tunis 1053
        </p>

        <p>
          <strong>Téléphone :</strong>
          +216 53 888 880
        </p>

        <p>
          <strong>Email :</strong>
          contact@damascino.tn
        </p>

      </div>

      <!-- HOURS -->

      <div class="footer-section hours">

        <h3>Horaires d'ouverture</h3>

        <ul>

          <li>
            Lundi - Vendredi : 11h - 23h
          </li>

          <li>
            Samedi - Dimanche : 11h - 00h
          </li>

        </ul>

      </div>

      <!-- SOCIAL -->

      <div class="footer-section social">

        <h3>Suivez-nous</h3>

        <div class="social-icons">

          <a
            href="https://www.facebook.com/damascino.orientalfood"
            class="social-icon"
          >
            <img
              src="images/facebook.png"
              alt="Facebook"
            >
          </a>

          <a
            href="https://www.instagram.com/damascino.orientalfood/"
            class="social-icon"
          >
            <img
              src="images/insta.png"
              alt="Instagram"
            >
          </a>

        </div>

      </div>

    </div>

    <div class="footer-bottom">

      <p>
        &copy; 2023 damascino.
        Tous droits réservés.
      </p>

    </div>

</footer>

<!-- JAVASCRIPT -->

<script>

function validateContact() {

    let nom = document
              .getElementById("name")
              .value
              .trim();

    let email = document
                .getElementById("email")
                .value
                .trim();

    let message = document
                  .getElementById("message")
                  .value
                  .trim();

    if(nom.length < 3) {

        alert(
          "Le nom doit contenir au moins 3 caractères"
        );

        return false;
    }

    if(!email.includes("@")) {

        alert("Email invalide");

        return false;
    }

    if(message.length < 10) {

        alert(
          "Le message doit contenir au moins 10 caractères"
        );

        return false;
    }

    return true;
}

</script>

</body>
</html>