<?php
include 'db.php';

echo "<h2>Installation de la base de données...</h2>";

// Lire le fichier SQL
$sql_file = file_get_contents('database_schema.sql');

// Diviser par les points-virgules pour obtenir les requêtes individuelles
$queries = array_filter(array_map('trim', preg_split('/;(?=(?:[^\']*\'[^\']*\')*[^\']*$)/', $sql_file)));

$count = 0;
$errors = [];

foreach ($queries as $query) {
    if (!empty($query)) {
        if (mysqli_query($conn, $query)) {
            $count++;
            echo "✓ Requête $count exécutée<br>";
        } else {
            $error = mysqli_error($conn);
            $errors[] = $error;
            echo "✗ Erreur: $error<br>";
        }
    }
}

echo "<hr>";
if (empty($errors)) {
    echo "<h3 style='color: green;'>✅ Installation complète ! ($count tables créées)</h3>";
    echo "<p><a href='menu.php'>Accéder au menu</a></p>";
} else {
    echo "<h3 style='color: red;'>⚠️ Des erreurs se sont produites</h3>";
    echo "<p>Erreurs: " . implode(", ", $errors) . "</p>";
}

mysqli_close($conn);
?>
