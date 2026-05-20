<?php require_once __DIR__ . '/init.php'; ensure_session(); render_page_head('À propos'); render_header('about.php'); ?>

<!-- Bienvenue -->
<section class="about-us">
  <div class="about-content">
    <h1>À propos de nous</h1>
    <p>Bienvenue chez Damascino, un restaurant où les saveurs authentiques de la cuisine orientale se mêlent à un savoir-faire raffiné pour offrir à nos clients une expérience gustative unique. Nous mettons un point d'honneur à utiliser des ingrédients frais et de qualité afin de vous faire voyager à travers des plats riches en goût et en tradition.</p>
   
    <!-- Valeurs -->
    <h1>Nos Valeurs</h1>
      <p>Qualité :</strong> Nous sélectionnons avec soin des ingrédients frais et de qualité afin de garantir l'authenticité et l'excellence de chaque plat.</p>
      <p>Passion :</strong> Du chef à l'équipe en salle, chacun partage la même passion pour la cuisine orientale et l'art de recevoir.</p>
      <p>Respect :</strong> Nous respectons nos clients, nos traditions culinaires et notre environnement pour offrir une expérience conviviale, responsable et mémorable.</p>
  
    <!-- team -->    
  <div class="team">
    <h2>Notre Équipe</h2>
    <div class="team-members">
      <div class="team-member">
        <img src="images/chef.png" alt="Chef">
        <h3>Chef isac</h3>
        <p>Notre chef principal, isac , est un passionné de cuisine orientale. Avec plus de 10 ans d'expérience, il crée des plats raffinés et délicieux qui font la renommée de notre restaurant.</p>
      </div>
      <div class="team-member">
        <img src="images/brigade.png" alt="brigade">
        <h3>Notre brigade</h3>
        <p>Notre brigade est professionnelle, attentive et passionnée. 
        Elle veille à préparer des plats de qualité pour rendre chaque visite agréable et mémorable.</p>

      </div>        
      <div class="team-member">
        <img src="images/serveur.png" alt="Serveurs">
        <h3>Nos serveurs</h3>
        <p> Nos serveurs sont attentifs, professionnels et toujours à l'écoute de nos clients.
            Ils veillent à offrir un service chaleureux et soigné afin de rendre chaque visite
            agréable et mémorable.</p>
      </div>
    </div>
  </div>

  <!-- Témoignages -->
    <section class="testimonials">
      <h2>Ce que disent nos clients</h2>
      <div class="testimonial">
    <p>"Food is delish 🤤 service is excellent . The waiters are very kind and helpful place is also very clean a variety of meals offered compared to the restaurant in menzah i highly recommend 👌"</p>
    <h4>- Marwa Saidi</h4>
  </div>
  <div class="testimonial">
    <p>"Very happy to find a place of quality and service, very nice place, great service and great food.
Good job."</p>
    <h4>- Sam Jabraouti</h4>
  </div>
    </section>
</section>

 
<?php render_footer(); ?>
