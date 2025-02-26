<?php
session_start();

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

// Vérifier si le nom d'utilisateur est stocké dans la session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "Salut, " . htmlspecialchars($username) . "!";

    # Bouton de déconnexion
    echo "<a href='logout.php'><button>Se déconnecter</button></a>";
} else {
    echo "Vous n'êtes pas connecté.";

    # Boutons de redirection
    echo "<a href='signup.php'><button>S'inscrire</button></a>";
    echo "<a href='login.php'><button>Se connecter</button></a>";
}



# Fermer la connexion
$conn->close();
?>
