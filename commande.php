<?php
require_once __DIR__ . '/init.php';
require_user();
$selectedPlatId = (int) ($_GET['plat_id'] ?? 0);

ensure_session();
render_page_head('Commande');
render_header('commande.php');
?>

  <section class="order-section">
    <div class="page-intro">
    <h1 class="order-title">Passer une commande</h1>
    <p class="order-description">Choisissez vos plats et validez votre commande.</p>
    </div>
    <div class="order-form-container">
      <form class="order-form" action="facture.php" method="POST">

        <!-- Informations personnelles -->
        <div class="form-group">
          <label for="name">Nom :</label>
          <input type="text" id="name" name="name" placeholder="Votre nom" required>
        </div>
        <div class="form-group">
          <label for="telephone">Téléphone :</label>
          <input type="tel" id="telephone" name="telephone" placeholder="Votre numéro de téléphone" required>
        </div>
        <div class="form-group">
          <label for="address">Adresse :</label>
          <input type="text" id="address" name="address" placeholder="Votre adresse complète" required>
        </div>

        <!-- Sélection des plats -->
        <h2 class="section-subtitle">Choisissez vos plats :</h2>

        <div class="menu-options">

          <!-- Entrées -->
          <h3 style="margin-top:15px; color:#8B0000;">🥗 Entrées</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish1" name="plats[]" value="Soupe aux lentilles|15" <?php echo $selectedPlatId === 1 ? 'checked' : ''; ?>>
            <label for="dish1">Soupe aux lentilles — 15 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish2" name="plats[]" value="Fattouch|10" <?php echo $selectedPlatId === 2 ? 'checked' : ''; ?>>
            <label for="dish2">Fattouch — 10 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish3" name="plats[]" value="Maza|20" <?php echo $selectedPlatId === 3 ? 'checked' : ''; ?>>
            <label for="dish3">Maza — 20 TND</label>
          </div>

          <!-- Plats principaux -->
          <h3 style="margin-top:15px; color:#8B0000;">🍖 Plats principaux</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish4" name="plats[]" value="Kebab mixte|80" <?php echo $selectedPlatId === 4 ? 'checked' : ''; ?>>
            <label for="dish4">Kebab mixte — 80 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish5" name="plats[]" value="Mandi poulet|40" <?php echo $selectedPlatId === 5 ? 'checked' : ''; ?>>
            <label for="dish5">Mandi poulet — 40 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish6" name="plats[]" value="Majouka|30" <?php echo $selectedPlatId === 6 ? 'checked' : ''; ?>>
            <label for="dish6">Majouka — 30 TND</label>
          </div>

          <!-- Desserts -->
          <h3 style="margin-top:15px; color:#8B0000;">🍮 Desserts</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish7" name="plats[]" value="Tiramisu|10" <?php echo $selectedPlatId === 7 ? 'checked' : ''; ?>>
            <label for="dish7">Tiramisu — 10 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish8" name="plats[]" value="Kunefa|30" <?php echo $selectedPlatId === 8 ? 'checked' : ''; ?>>
            <label for="dish8">Kunefa — 30 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish9" name="plats[]" value="Layali lebnan|15" <?php echo $selectedPlatId === 9 ? 'checked' : ''; ?>>
            <label for="dish9">Layali lebnan — 15 TND</label>
          </div>

          <!-- Boissons -->
          <h3 style="margin-top:15px; color:#8B0000;">🥤 Boissons</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish10" name="plats[]" value="Citronnade|9" <?php echo $selectedPlatId === 10 ? 'checked' : ''; ?>>
            <label for="dish10">Citronnade — 9 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish11" name="plats[]" value="Thé à la Menthe|12" <?php echo $selectedPlatId === 11 ? 'checked' : ''; ?>>
            <label for="dish11">Thé à la Menthe — 12 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish12" name="plats[]" value="Ayrane|10" <?php echo $selectedPlatId === 12 ? 'checked' : ''; ?>>
            <label for="dish12">Ayrane — 10 TND</label>
          </div>

          <!-- Spécialités -->
          <h3 style="margin-top:15px; color:#8B0000;">⭐ Spécialités</h3>
          <div class="menu-item">
            <input type="checkbox" id="dish13" name="plats[]" value="Sambousek|15">
            <label for="dish13">Sambousek — 15 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish14" name="plats[]" value="Warak enab|20">
            <label for="dish14">Warak enab — 20 TND</label>
          </div>
          <div class="menu-item">
            <input type="checkbox" id="dish15" name="plats[]" value="Kebba|10">
            <label for="dish15">Kebba — 10 TND</label>
          </div>

        </div>

        <!-- Total en temps réel (JavaScript) -->
        <div class="invoice-summary" style="margin-top:20px;">
          <p><strong>Total estimé : <span id="total">0</span> TND</strong></p>
        </div>

        <!-- Instructions spéciales -->
        <div class="form-group">
          <label for="instructions">Instructions spéciales :</label>
          <textarea id="instructions" name="instructions" rows="4" placeholder="Ajoutez des commentaires ou des demandes spécifiques"></textarea>
        </div>

        <!-- Soumettre -->
        <button type="submit" class="btn-submit">Passer la commande</button>
      </form>
    </div>
  </section>
<?php render_footer(); ?>
<!-- JavaScript : calcul du total en temps réel + validation -->
  <script>
    // Calcul du total en temps réel
    const checkboxes = document.querySelectorAll('input[name="plats[]"]');
    const totalSpan  = document.getElementById('total');

    function updateTotal() {
      let total = 0;
      checkboxes.forEach(c => {
        if (c.checked) {
          total += parseInt(c.value.split('|')[1], 10);
        }
      });
      totalSpan.textContent = total;
    }

    checkboxes.forEach(cb => {
      cb.addEventListener('change', updateTotal);
    });

    updateTotal();

    // Validation : vérifier qu'un plat est coché avant d'envoyer
    document.querySelector('.order-form').addEventListener('submit', function(e) {
      const unPlatCoche = Array.from(checkboxes).some(c => c.checked);

      if (!unPlatCoche) {
        e.preventDefault(); // Bloque l'envoi du formulaire
        alert('⚠️ Veuillez sélectionner au moins un plat avant de passer la commande !');
      }
    });
  </script>

</body>
</html>
