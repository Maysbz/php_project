<?php

require_once __DIR__ . '/config/database.php';

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function app_base_path(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $docRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');
    $projectRoot = realpath(__DIR__) ?: __DIR__;

    if ($docRoot && $projectRoot) {
        $docRootNorm = str_replace('\\', '/', $docRoot);
        $projectNorm = str_replace('\\', '/', $projectRoot);
        if (str_starts_with($projectNorm, $docRootNorm)) {
            $base = rtrim(substr($projectNorm, strlen($docRootNorm)), '/');
            return $base;
        }
    }

    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    if (preg_match('#^(.*?)/admin(/|$)#', $script, $matches)) {
        $base = rtrim($matches[1], '/');
    } else {
        $base = '';
    }

    return $base;
}

function url(string $path): string
{
    $path = ltrim(str_replace('\\', '/', $path), '/');
    $base = app_base_path();

    return $base === '' ? '/' . $path : $base . '/' . $path;
}

function page_url(string $path = 'index.php'): string
{
    return url(ltrim($path, '/'));
}

function admin_url(string $path = 'index.php'): string
{
    return url('admin/' . ltrim($path, '/'));
}

function asset_url(string $path): string
{
    return url(ltrim($path, '/'));
}

function is_admin_context(): bool
{
    return str_contains(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''), '/admin/');
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit();
}

function ensure_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        $sessionPath = __DIR__ . '/storage/sessions';
        if (!is_dir($sessionPath)) {
            mkdir($sessionPath, 0777, true);
        }
        if (is_writable($sessionPath)) {
            session_save_path($sessionPath);
        }
        session_start();
    }
}

function require_user(): void
{
    ensure_session();
    if (!isset($_SESSION['user'])) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? page_url('index.php');
        redirect(page_url('auth/login.php'));
    }
}

function render_auth_nav(): void
{
    ensure_session();
    if (isset($_SESSION['user'])) {
        if (($_SESSION['role'] ?? '') === 'admin') {
            echo '<li><a href="' . e(admin_url('index.php')) . '">Admin</a></li>';
        }
        echo '<li><a href="' . e(page_url('auth/logout.php')) . '" class="Connexion">Deconnexion</a></li>';
        return;
    }
    echo '<li><a href="' . e(page_url('auth/login.php')) . '" class="Connexion">Connexion</a></li>';
}

function asset_path(string $file): string
{
    return str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/auth/') ? '../' . $file : $file;
}

function asset_version(string $projectFile): string
{
    $absolute = __DIR__ . '/' . ltrim($projectFile, '/');
    return is_file($absolute) ? (string) filemtime($absolute) : (string) time();
}

function versioned_asset(string $file): string
{
    return asset_path($file) . '?v=' . asset_version($file);
}

function versioned_asset_href(string $href): string
{
    $file = basename(parse_url($href, PHP_URL_PATH) ?: $href);
    return $href . '?v=' . asset_version($file);
}

function render_page_head(string $title): void
{
    echo '<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . e($title) . ' — Damascino</title>
  <link rel="stylesheet" href="' . e(versioned_asset('style.css')) . '">
</head>
<body>';
}

function render_header(string $active = ''): void
{
    $links = [
        'index.php' => 'Accueil',
        'menu.php' => 'Menu',
        'about.php' => 'À propos',
        'contact.php' => 'Contact',
        'reservation.php' => 'Réservation',
        'discount.php' => 'Offres',
    ];
    echo '<header class="main-header">
    <a href="' . e(page_url('index.php')) . '" class="logo">damascino</a>
    <nav class="navbar">
      <ul>';
    foreach ($links as $file => $label) {
        $class = $active === $file ? ' class="active"' : '';
        echo '<li><a href="' . e(page_url($file)) . '"' . $class . '>' . e($label) . '</a></li>';
    }
    render_auth_nav();
    echo '</ul>
    </nav>
  </header>';
}

function render_footer(): void
{
    echo '<footer class="main-footer">
    <div class="footer-container">
      <div class="footer-section">
        <h3>À propos</h3>
        <p>Cuisine levantine authentique et accueil chaleureux au cœur de Tunis.</p>
      </div>
      <div class="footer-section">
        <h3>Contact</h3>
        <p>Rue de la Feuille d\'Érable, Tunis 1053</p>
        <p><a href="tel:+21653888880">+216 53 888 880</a></p>
        <p><a href="mailto:contact@damascino.tn">contact@damascino.tn</a></p>
      </div>
      <div class="footer-section">
        <h3>Horaires</h3>
        <ul>
          <li>Lun – Ven : 11h – 23h</li>
          <li>Sam – Dim : 11h – 00h</li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
          <a href="https://www.facebook.com/damascino.orientalfood" class="social-icon" aria-label="Facebook"><img src="' . e(asset_path('images/facebook.png')) . '" alt=""></a>
          <a href="https://www.instagram.com/damascino.orientalfood/" class="social-icon" aria-label="Instagram"><img src="' . e(asset_path('images/insta.png')) . '" alt=""></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; ' . date('Y') . ' Damascino. Tous droits réservés.</p>
    </div>
  </footer>
</body>
</html>';
}

function auth_home_url(): string
{
    return is_admin_context() ? admin_url('index.php') : page_url('index.php');
}

function auth_login_url(): string
{
    return is_admin_context() ? admin_url('auth/login.php') : page_url('auth/login.php');
}

function user_find_by_email(string $email): ?array
{
    $pdo = db_pdo();
    $stmt = $pdo->prepare('SELECT id, username, email, phone, password, role FROM users WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    return $user ? ['id' => (int) $user['id'], 'user' => $user] : null;
}

function user_create(string $username, string $email, string $phone, string $password): array
{
    $role = in_array($email, ['admin@damascino.tn', 'owner@damascino.tn'], true) ? 'admin' : 'client';
    $pdo = db_pdo();
    $stmt = $pdo->prepare('INSERT INTO users (username, email, phone, password, role) VALUES (:u, :e, :p, :pw, :r)');
    $stmt->execute([
        ':u' => $username,
        ':e' => $email,
        ':p' => $phone,
        ':pw' => password_hash($password, PASSWORD_DEFAULT),
        ':r' => $role,
    ]);

    return [
        'id' => (int) $pdo->lastInsertId(),
        'user' => ['username' => $username, 'email' => $email, 'phone' => $phone, 'role' => $role],
    ];
}

function user_is_admin(string $email): bool
{
    try {
        $found = user_find_by_email($email);
    } catch (Throwable $e) {
        return false;
    }

    return ($found['user']['role'] ?? '') === 'admin';
}

function handle_login_post(): void
{
    ensure_session();
    if (isset($_SESSION['user'])) {
        redirect(auth_home_url());
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        redirect(auth_login_url());
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    if ($email === '') {
        $errors[] = "L'adresse email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }
    if ($password === '') {
        $errors[] = 'Le mot de passe est obligatoire.';
    }

    $found = null;
    if (!$errors) {
        try {
            $found = user_find_by_email($email);
            if (!$found) {
                $errors[] = 'Aucun compte trouve avec cette adresse email.';
            } elseif (!password_verify($password, $found['user']['password'] ?? '')) {
                $errors[] = 'Mot de passe incorrect.';
            }
        } catch (Throwable $e) {
            $errors[] = 'Base de donnees indisponible. Verifiez MySQL et database_schema.sql.';
        }
    }

    if ($errors) {
        $_SESSION['login_errors'] = $errors;
        $_SESSION['login_email'] = $email;
        redirect(auth_login_url());
    }

    $_SESSION['user'] = $found['user']['email'];
    $_SESSION['username'] = $found['user']['username'];
    $_SESSION['user_id'] = $found['id'];
    $_SESSION['role'] = $found['user']['role'] ?? 'client';

    $target = $_SESSION['redirect_after_login'] ?? auth_home_url();
    unset($_SESSION['redirect_after_login']);
    redirect($target);
}

function get_menu(): array
{
    try {
        $conn = db_mysqli();
        $categories = [];
        $result = $conn->query('SELECT DISTINCT categorie FROM plat WHERE actif = 1 ORDER BY categorie');
        while ($row = $result->fetch_assoc()) {
            $categories[$row['categorie']] = [];
        }
        if ($categories) {
            $stmt = $conn->prepare('SELECT id, nom, description, prix, categorie, image FROM plat WHERE actif = 1 ORDER BY categorie, nom');
            $stmt->execute();
            $plats = $stmt->get_result();
            while ($plat = $plats->fetch_assoc()) {
                $categories[$plat['categorie']][] = $plat;
            }
        }
        return ['menuByCategory' => $categories, 'menuWarning' => ''];
    } catch (Throwable $e) {
        return ['menuByCategory' => get_fallback_menu(), 'menuWarning' => 'Menu par defaut (base indisponible).'];
    }
}

function get_fallback_menu(): array
{
    return [
        'Entrees' => [
            ['id' => 1, 'nom' => 'Soupe aux lentilles', 'description' => 'Soupe traditionnelle', 'prix' => 15, 'image' => 'images/soupe.jpg'],
            ['id' => 2, 'nom' => 'Fattouch', 'description' => 'Salade levantine', 'prix' => 10, 'image' => 'images/Fattouch.jpg'],
        ],
        'Plats principaux' => [
            ['id' => 4, 'nom' => 'Kebab mixte', 'description' => 'Kebab mixte', 'prix' => 80, 'image' => 'images/kebabmix.jpg'],
            ['id' => 5, 'nom' => 'Mandi poulet', 'description' => 'Riz epice', 'prix' => 40, 'image' => 'images/mandi.png'],
        ],
        'Desserts' => [
            ['id' => 8, 'nom' => 'Kunefa', 'description' => 'Patisserie syrienne', 'prix' => 30, 'image' => 'images/kunefa.jpg'],
        ],
    ];
}

function save_contact(string $nom, string $email, string $message): bool
{
    $stmt = db_mysqli()->prepare('INSERT INTO contact (nom, email, message) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $nom, $email, $message);

    return $stmt->execute();
}

function save_reservation(array $data): bool
{
    $stmt = db_mysqli()->prepare(
        'INSERT INTO reservation_table (nom, email, telephone, date_reservation, heure_reservation, nb_personnes, instructions)
         VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->bind_param(
        'sssssis',
        $data['nom'],
        $data['email'],
        $data['telephone'],
        $data['date'],
        $data['heure'],
        $data['nb_personnes'],
        $data['instructions']
    );

    return $stmt->execute();
}

function save_order(array $customer, array $items, float $total): void
{
    $pdo = db_pdo();
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO commande (nom, telephone, adresse, instructions, total)
             VALUES (:nom, :tel, :adr, :inst, :total)'
        );
        $stmt->execute([
            ':nom' => $customer['name'],
            ':tel' => $customer['telephone'],
            ':adr' => $customer['address'],
            ':inst' => $customer['instructions'],
            ':total' => $total,
        ]);
        $commandeId = (int) $pdo->lastInsertId();

        $line = $pdo->prepare('INSERT INTO ligne_commande (commande_id, nom_plat, prix) VALUES (:cid, :nom, :prix)');
        foreach ($items as $item) {
            $line->execute([':cid' => $commandeId, ':nom' => $item['nom'], ':prix' => $item['prix']]);
        }

        $inv = $pdo->prepare('INSERT INTO facture (commande_id, montant_total) VALUES (:cid, :total)');
        $inv->execute([':cid' => $commandeId, ':total' => $total]);

        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
