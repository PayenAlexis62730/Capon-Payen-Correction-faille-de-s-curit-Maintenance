<?php
session_start();
# Connexion sécurisée à la base de données
$servername = "localhost:3360";
$username = "root"; 
$password = "root"; 
$dbname = "maintenance"; 

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

# Récupération des données du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    # Préparation et exécution de la requête SQL sécurisée
    // Au lieu d'injecter directement les variables dans la requête SQL, nous utilisons une requête préparée avec des paramètres liés pour éviter les injections SQL.
    $stmt = $conn->prepare("SELECT password FROM Users WHERE username = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    # Vérification du mot de passe haché
    // je vais utiliser password_verify pour comparer le mot de passe utilisateur avec le mot de passe haché stocké dans la base de données.
    if (password_verify($password, $hashed_password)) {
        $_SESSION['name'] = $name;
        session_regenerate_id(true); // Securisation de la session en régénérant l'ID pour ne pas avoir de problème aveec la fixation de session.
        header("Location: index.php?name=" . urlencode($name));
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
</head>
<body>
    <form method="post" action="">
        <label for="name">Nom d'utilisateur :</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
