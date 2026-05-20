-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'admin') DEFAULT 'client',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO users (username, email, phone, password, role) VALUES
('Admin', 'admin@damascino.tn', '00000000', '$2y$10$RMAu9rnnsDzxFA4tA.JHsu14X9h8TvpUlC3xK.wb4FCH/9af13AFS', 'admin');

-- Table: plat
CREATE TABLE IF NOT EXISTS plat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    categorie VARCHAR(50) NOT NULL,
    image VARCHAR(255),
    actif BOOLEAN DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_plat_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: reservation_table
CREATE TABLE IF NOT EXISTS reservation_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    date_reservation DATE NOT NULL,
    heure_reservation TIME NOT NULL,
    nb_personnes INT NOT NULL,
    instructions TEXT,
    status ENUM('en attente', 'confirmee', 'annulee') DEFAULT 'en attente',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: contact
CREATE TABLE IF NOT EXISTS contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    statut ENUM('non lu', 'lu', 'traite') DEFAULT 'non lu',
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: offre
CREATE TABLE IF NOT EXISTS offre (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    nom VARCHAR(100) NOT NULL,
    reduction INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    actif BOOLEAN DEFAULT 1,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: commande
CREATE TABLE IF NOT EXISTS commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    instructions TEXT,
    total DECIMAL(10, 2) NOT NULL,
    status ENUM('en attente', 'confirmee', 'annulee') DEFAULT 'en attente',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: ligne_commande
CREATE TABLE IF NOT EXISTS ligne_commande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    nom_plat VARCHAR(100) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: facture
CREATE TABLE IF NOT EXISTS facture (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    montant_total DECIMAL(10, 2) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer les plats existants
INSERT IGNORE INTO plat (nom, description, prix, categorie, image) VALUES
-- Entrées
('Soupe aux lentilles', 'Soupe traditionnelle aux lentilles', 15.00, 'Entrées', 'images/soupe.jpg'),
('Fattouch', 'Salade levantine avec pain grillé', 10.00, 'Entrées', 'images/Fattouch.jpg'),
('Maza', 'Assortiment de dips et mezze', 20.00, 'Entrées', 'images/maza.jpg'),

-- Plats principaux
('Kebab mixte', 'Kebab avec viandes assorties', 80.00, 'Plats principaux', 'images/kebabmix.jpg'),
('Majouka', 'Ragoût traditionnel syrien', 30.00, 'Plats principaux', 'images/majouka.jpg'),
('Mandi poulet', 'Riz épicé avec poulet', 40.00, 'Plats principaux', 'images/mandi.png'),

-- Desserts
('Tiramisu', 'Dessert italien classique', 10.00, 'Desserts', 'images/tiramisu.jpg'),
('Kunefa', 'Pâtisserie syrienne au fromage', 30.00, 'Desserts', 'images/kunefa.jpg'),
('Layali lebnan', 'Crème aux fruits secs', 15.00, 'Desserts', 'images/layalilibnan.jpg'),

-- Boissons
('Citronnade', 'Citronnade fraîche', 9.00, 'Boissons', 'images/citronade.jpeg'),
('Thé à la Menthe', 'Thé traditionnel à la menthe', 12.00, 'Boissons', 'images/Thé_à_la_Menthe.jpg'),
('Ayrane', 'Boisson lactée traditionnelle', 10.00, 'Boissons', 'images/ayran.jpg');
