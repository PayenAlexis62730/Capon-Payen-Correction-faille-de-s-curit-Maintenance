# Capon-Payen-Correction-faille-de-sécuriter (Maintenance)

# Bilan de Sécurité : Application Web

Ce document réarmé a été rédigé par Payen Alexis et Hugo Capon pour décrire les failles de sécurité présentes dans l'application web de Nathan Fourny et Pauline David et les solutions mises en place pour 
Qu'on les corrige.

---

## Issue 1 : Les Injection SQL e

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
