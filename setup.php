<?php
$servername = "localhost:3360"; // Nom du serveur MySQL, par défaut localhost
$username = "root"; // Nom d'utilisateur de la base de donnée, par défaut root
$password = "root"; // Mot de passe utilisateur de la base de donnée, par défaut root

// Créer une connexion
$conn = new mysqli($servername, $username, $password);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Créer la base de données maintenance
$sql = "CREATE DATABASE IF NOT EXISTS maintenance";
if ($conn->query($sql) === TRUE) {
    echo "Base de données créée avec succès<br>";
} else {
    echo "Erreur lors de la création de la base de données : " . $conn->error . "<br>";
}

// Sélectionner la base de données maintenance
$conn->select_db("maintenance");

// Créer la table Users
$sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(250) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Table Users créée avec succès<br>";
} else {
    echo "Erreur lors de la création de la table : " . $conn->error . "<br>";
}

// Fermer la connexion
$conn->close();
?>