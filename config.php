<?php
// ========================================
// CONFIGURATION DE LA CONNEXION À LA BASE
// ========================================

$host = "localhost";
$user = "root";
$password = ""; // mot de passe vide (WAMP/XAMPP)
$dbname = "tourisme"; // ta base de données

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
