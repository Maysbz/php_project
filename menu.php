<?php
include("db.php");

$sql = "SELECT * FROM plat";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Restaurant - Menu</title>

  <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="main-header">

    <div class="logo">damascino</div>

    <nav class="navbar">
        <ul>
          <li><a href="index.html">Accueil</a></li>
          <li><a href="menu.php">Menu</a></li>
          <li><a href="about.html">À propos</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="reservation.php">Réservation</a></li>
          <li><a href="discount.html">Offres</a></li>
          <li><a href="login.html" class="Connexion">Connexion</a></li>
        </ul>
    </nav>

</header>

<!-- MENU -->

<section class="menu-section">

  <h1 class="menu-title">Notre Menu</h1>

  <div class="menu-category">

    <h2>Tous les plats</h2>

    <div class="menu-items">

      <?php while($row = mysqli_fetch_assoc($result)) { ?>

      <div class="menu-item">

        <img
          src="images/<?php echo $row['image']; ?>"
          alt="<?php echo $row['nom']; ?>"
        >

        <div class="item-details">

          <h3>
            <?php echo $row['nom']; ?>
          </h3>

          <p>
            <?php echo $row['description']; ?>
          </p>

          <p>
            Prix :
            <?php echo $row['prix']; ?> TND
          </p>

          <a href="commande.html" class="order-btn">
            Commander
          </a>

        </div>

      </div>

      <?php } ?>

    </div>

  </div>

</section>

<!-- NOS SPÉCIALITÉS -->

<section class="specialties-section">

  <h2 class="section-title">
    Nos Spécialités
  </h2>

  <div class="specialties-container">

    <div class="specialty-item">

      <img
        src="images/samboussek.jpeg"
        alt="Sambousek"
        class="specialty-img"
      >

      <h3>Sambousek</h3>

      <p>
        Un chausson salé croustillant emblématique
        de la cuisine du Moyen-Orient.
      </p>

      <a href="commande.html" class="order-btn">
        Commander
      </a>

    </div>

    <div class="specialty-item">

      <img
        src="images/warakenab.jpg"
        alt="Warak enab"
        class="specialty-img"
      >

      <h3>Warak enab</h3>

      <p>
        Feuilles de vigne farcies avec riz,
        viande hachée et épices orientales.
      </p>

      <a href="commande.html" class="order-btn">
        Commander
      </a>

    </div>

    <div class="specialty-item">

      <img
        src="images/kebba.jpg"
        alt="Kebba"
        class="specialty-img"
      >

      <h3>Kebba</h3>

      <p>
        Croquettes orientales au boulgour,
        viande et pignons de pin.
      </p>

      <a href="commande.html" class="order-btn">
        Commander
      </a>

    </div>

  </div>

</section>

<!-- FOOTER -->

<footer class="main-footer">

    <div class="footer-container">

      <!-- About -->

      <div class="footer-section about">

        <h3>À propos de nous</h3>

        <p>
          Damascino vous invite à un voyage culinaire
          au cœur de la Syrie, où l'authenticité
          des saveurs levantines rencontre
          la générosité d'un accueil chaleureux.
        </p>

      </div>

      <!-- Contact -->

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

      <!-- Hours -->

      <div class="footer-section hours">

        <h3>Horaires d'ouverture</h3>

        <ul>
          <li>Lundi - Vendredi : 11h - 23h</li>
          <li>Samedi - Dimanche : 11h - 00h</li>
        </ul>

      </div>

      <!-- Social -->

      <div class="footer-section social">

        <h3>Suivez-nous</h3>

        <div class="social-icons">

          <a
            href="https://www.facebook.com/damascino.orientalfood"
            class="social-icon"
          >
            <img src="images/facebook.png" alt="Facebook">
          </a>

          <a
            href="https://www.instagram.com/damascino.orientalfood/"
            class="social-icon"
          >
            <img src="images/insta.png" alt="Instagram">
          </a>

        </div>

      </div>

    </div>

    <div class="footer-bottom">
      <p>&copy; 2023 damascino. Tous droits réservés.</p>
    </div>

</footer>

</body>
</html>