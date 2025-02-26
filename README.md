# Capon-Payen-Correction-faille-de-sécuriter (Maintenance)

# Bilan de Sécurité : Application Web

Ce document réarmé a été rédigé par Payen Alexis et Hugo Capon pour décrire les failles de sécurité présentes dans l'application web de Nathan Fourny et Pauline David et les solutions mises en place pour 
Qu'on les corrige.

---

## Issue 1 : Les Injections SQL 

### Le gros Problème :
L'injection SQL est une vulnérabilité critique qui permettrait un hacker d'injecter des commandes SQL malveillantes dans des requêtes de base de données. 

### Code vulnérable :

```php
$sql = "SELECT password FROM Users WHERE username = '$name' AND password = '$password'";
```

### Notre Solution :
Pour éviter les injections SQL, nous utilisons des requêtes préparées avec des paramètres liés. Cela va garantir que les entrées utilisateur ne sont pas interprétées comme du code SQL pour empecher les injections.

```php
$stmt = $conn->prepare("SELECT password FROM Users WHERE username = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
```

### Pourquoi c'est mieux ? :
- Les requêtes préparées permettent de séparer les données des commandes SQL .
- Même si un hacker injecte du code malveillant, celui-ci sera interprété comme des données, et non comme une commande SQL, donc il a le seum et la BDD est protéger.
- Les informations sensibles des utilisateurs sont mieux sécurisées.

## Issue 2 : Les Mots de passes

### Le gros Problème :
En laissant kes mots de passe en clair, Les mots de passe sont stockés sans aucune protection. Si la base de données est compromise ou hacker, les mots de passe des utilisateurs seront exposés aux utilisateurs maveillants.
De plus l'ID de session reste inchangé après la connexion, ce qui expose l'application à des attaques de fixation de session.

### Code vulnérable :

```php
$sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
```

### Notre Solution :

Pour éviter cela le but ici est de hasher les mots de passe et de vérifier le mot de passe

```php
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
```

Deplus on va vérifier que lors de la connexion que le mot de passe de l'utilisateur avec le hashage dans la BDD soit le même.

```php
if (password_verify($password, $hashed_password)) {
    $_SESSION['name'] = $name;
    session_regenerate_id(true); // Sécurisation de la session
}
```
Enfin on va régénérer l'id du compte après une connexion réussie cela permettra de  sécuriser la session de l'utilisateur des attaques de session fixe.

### Pourquoi c'est mieux ? :

- Les mots de passe Hasher rendent impossible la récupération des mots de passe en clair.
- La régénération de l'ID de session empêche les hackers de voler ou manipuler l'ID de session d'un utilisateur.
