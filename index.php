<?php
echo "<a href='setup.php'><button>Installer la base de données</button></a> <br />";
# Connexion sécurisée à la base de données
$servername = "localhost:3360"; 
$username = "root"; 
$password = "root"; 
$dbname = "maintenance"; 

# Connexion à la base
$conn = new mysqli($servername, $username, $password, $dbname);

# Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
echo "Connexion réussie à la base de données MySQL <br /><br />";

# Échappement des variables pour éviter les attaques XSS
if (isset($_GET['name'])) {
    $name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
    echo "Salut " . $name . "<br />";
}

# Boutons de redirection
echo "<a href='signup.php'><button>S'inscrire</button></a>";
echo "<a href='login.php'><button>Se connecter</button></a>";

# Fermer la connexion
$conn->close();
?>
