<?php
session_start();

# Connexion sécurisée à la base de données
$servername = "localhost:3360"; 
$username = "root"; 
$password = "root"; 
$dbname = "maintenance"; 

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

# Récupération des données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    # Hachage du mot de passe avant de le stocker
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Je vais utiliser une requête préparée pour éviter les injections SQL.
    $stmt = $conn->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {

        // Stocker le nom d'utilisateur dans la session
        $_SESSION['username'] = $username;

        /////////////// avant
        // header("Location: index.php");
        //////////////////////////

        /////////////// après
        header("Location: index.php");
        //////////////////////////

        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'Inscription</title>
</head>
<body>
    <form method="post" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
