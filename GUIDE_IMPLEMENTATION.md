# Guide d'utilisation - Damascino Restaurant

## 🎯 TRAVAIL RÉALISÉ - PERSONNE 3 (Réservation + Contact + Plat)

### ✅ Fichiers PHP convertis en pages dynamiques :
1. **menu.php** - Affiche les plats depuis la BDD
   - Récupère automatiquement les plats de la table `plat`
   - Regroupe par catégorie
   - Liens de commande dynamiques

2. **contact.php** - Formulaire de contact avec traitement
   - Validation côté serveur et client
   - Validation email (regex)
   - Sauvegarde dans la table `contact`
   - Affichage des messages de succès/erreur
   - JavaScript pour validation en temps réel

3. **reservation.php** - Formulaire de réservation avec validation
   - Blocage des dates passées (input min + JavaScript)
   - Validation du téléphone, email, nombre de personnes
   - Traitement et sauvegarde en BDD
   - Dates minimales appliquées côté serveur ET client

### ✅ Tables BDD créées :
```sql
-- Dans database_schema.sql --
CREATE TABLE plat (id, nom, description, prix, categorie, image, actif, date_creation)
CREATE TABLE reservation_table (id, user_id, nom, email, telephone, date_reservation, heure_reservation, nb_personnes, instructions, status)
CREATE TABLE contact (id, nom, email, message, statut, date_envoi)
CREATE TABLE offre (id, code, nom, reduction, date_debut, date_fin, actif, date_creation)
```

---

## 🎯 TRAVAIL RÉALISÉ - PERSONNE 4 (Admin + Offre)

### ✅ Structure Admin créée :
- **admin/auth.php** - Authentification et menu admin
- **admin/functions.php** - Toutes les fonctions CRUD

### ✅ Pages Admin :

1. **admin/index.php** - Dashboard
   - Statistiques en temps réel
   - Total plats, réservations du mois, contacts non lus, offres actives
   - Liens d'accès rapide

2. **admin/produits.php** - CRUD Plats + Upload image
   - Créer/Éditer/Supprimer les plats
   - Upload image avec validation (jpg, png, gif, webp, max 5MB)
   - **Preview image AVANT upload** (JavaScript)
   - Gestion des catégories

3. **admin/reservations.php** - Gestion des réservations
   - Voir toutes les réservations
   - Changer le statut (en attente, confirmée, annulée)
   - Filtrage par date

4. **admin/commandes.php** - Gestion des commandes
   - Affichage des commandes (si table existe)
   - Prêt pour intégration avec la table commande

5. **admin/clients.php** - Gestion Clients & Contacts
   - Voir les messages de contact
   - Changer le statut (non lu, lu, traité)
   - Lien vers gestion des offres

6. **admin/offres.php** - Gestion Offres Promotionnelles
   - Créer/Éditer/Supprimer les offres
   - Codes promo avec réduction (%)
   - Dates de validité
   - Activation/Désactivation

---

## 🔧 Installation & Utilisation

### 1. Créer les tables BDD :
```bash
# Importer le fichier SQL
mysql -u root -p restaurant_db < database_schema.sql

# OU Copier-coller le contenu de database_schema.sql dans phpMyAdmin
```

### 2. Accéder aux pages :

**Public :**
- http://localhost/php_project/menu.php
- http://localhost/php_project/contact.php
- http://localhost/php_project/reservation.php

**Admin (après connexion) :**
- http://localhost/php_project/admin/index.php

### 3. Authentification Admin :
- L'accès admin nécessite session + email admin (voir admin/auth.php)
- À configurer selon votre système d'authentification

---

## 📝 Validations Appliquées

### Contact :
- ✅ Nom : min 2 caractères
- ✅ Email : validation regex
- ✅ Message : min 10 caractères

### Réservation :
- ✅ Nom : min 2 caractères
- ✅ Téléphone : validation format
- ✅ Email : validation regex
- ✅ Date : pas de dates passées (input min + JavaScript)
- ✅ Nombre de personnes : 1-20

### Produits (Admin) :
- ✅ Nom, Prix, Catégorie obligatoires
- ✅ Image : jpg, png, gif, webp (max 5MB)
- ✅ Preview avant upload

---

## 📊 Statistiques Dashboard

Le dashboard affiche en temps réel :
- **Total Plats** : nombre de plats actifs
- **Réservations ce mois** : du mois courant
- **Contacts non lus** : messages non traités
- **Offres Actives** : nombre d'offres en cours

---

## 🔐 Sécurité

✅ Escaping des entrées utilisateur (mysqli_real_escape_string)
✅ Validation côté serveur + client
✅ Authentification pour l'admin
✅ Vérification des permissions

---

## 📂 Structure des fichiers

```
php_project/
├── menu.php (converti en PHP dynamique)
├── contact.php (converti en PHP dynamique)
├── reservation.php (converti en PHP dynamique)
├── database_schema.sql (nouvelle)
├── admin/
│   ├── index.php (dashboard)
│   ├── auth.php (authentification)
│   ├── functions.php (fonctions CRUD)
│   ├── produits.php (CRUD plats)
│   ├── reservations.php (gestion réservations)
│   ├── commandes.php (gestion commandes)
│   ├── clients.php (gestion contacts)
│   └── offres.php (gestion offres)
├── db.php (connexion BDD)
└── ... (autres fichiers existants)
```

---

## ⚠️ À compléter

1. **Intégration commande.php** :
   - Créer la table `commande` en BDD
   - Remplir commande.php avec traitement POST
   - Lier à la facturation

2. **Système de paiement** :
   - Intégrer facture.php avec calcul des commandes

3. **Système d'authentification** :
   - Vérifier les rôles admin dans la table users
   - Ajouter colonne "role" à users si nécessaire

4. **Gestion des images** :
   - Créer dossier `images/` avec permissions d'écriture
   - Optimiser les uploads d'images

---

## 💡 Prochaines étapes

- [ ] Tester toutes les validations
- [ ] Importer les données de plats en BDD
- [ ] Configurer l'authentification admin
- [ ] Compléter la gestion des commandes
- [ ] Ajouter des statistiques avancées
- [ ] Implémenter les rapports PDF pour les réservations/commandes
