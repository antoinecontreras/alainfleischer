<?php
$host = 'localhost';
$db = 'leza2735_database';
$user = 'leza2735_admin';
$pass = 'aLN8-ynKu-6pJ?';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données!";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>