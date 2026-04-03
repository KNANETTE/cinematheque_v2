# CINEMATHEQUE

Cinematheque est une application web de type boutique de films.
Elle permet à un utilisateur de découvrir des films via l’API TMDB, de consulter leurs fiches détaillées, de les ajouter à un panier, puis de simuler un achat.
Le projet est pensé comme une base propre et évolutive pour un site de type e-commerce autour du cinéma.

---

## Sommaire

* [Fonctionnalités](#fonctionnalités)
* [Technologies utilisées](#technologies-utilisées)
* [Installation](#installation)
* [Configuration](#configuration)
* [Structure du projet](#structure-du-projet)
* [Fonctionnement](#fonctionnement)
* [Évolutions possibles](#évolutions-possibles)
* [Licence](#licence)

---

## Fonctionnalités

* Recherche de films via l’API TMDB
* Affichage de fiches films (titre, synopsis, affiche, etc.)
* Ajout de films à un panier (sessions PHP)
* Validation du panier et enregistrement des achats en base de données
* Page profil utilisateur avec formulaire d’édition (username, nom complet, email, mot de passe)
* Formulaire de profil désactivé par défaut, activable via un switch
* Authentification basique (inscription / connexion)
* Interface responsive avec Bootstrap

---

## Technologies utilisées

* **PHP 8+** — logique backend, sessions, routes simples
* **MySQL** — stockage des utilisateurs et des achats
* **PDO** — accès base de données avec requêtes préparées
* **TMDB API** — récupération des données films
* **HTML5 / CSS3**
* **Bootstrap 5** — mise en page et composants UI
* **JavaScript** — interactions (DOM, fetch, switch d’édition du profil)

---

## Installation

### 1. unzip le dossier

### 2. Configurer la base de données

1. Importer le fichier SQL fourni :

```bash
# Exemple
mysql -u root < database_schema.sql
```

Les tables typiques sont :

* `users`
* `purchases`

### 3. Configurer l’accès à la base et l’API TMDB

Remplir le fichier .env à partir de l'exemple .env.example

### 4. Lancer le serveur PHP

```bash
php -S localhost:8000
```

Puis ouvrir dans le navigateur :

```
http://localhost:8000
```

---

## Structure du projet

Exemple de structure (à adapter à ton repo réel) :

```text
/scripts
    auth.js
    movies.js

/src
    functions/
        db.php
    pages/
        ...
    templates/
        ...

/styles
    CSS files

index.php
logout.php
auth.php
movies.php
```

---

## Fonctionnement

### 1. Récupération des films (TMDB)

* Les films sont récupérés via l’API TMDB (requêtes HTTP).
* Les données sont transformées en tableaux associatifs PHP.
* Les résultats sont affichés sous forme de cartes (Bootstrap) sur la page d’accueil ou de recherche.

### 2. Panier (sessions PHP)

* Le panier est stocké dans `$_SESSION['cart']`.
* Chaque entrée du panier est un tableau associatif représentant un film (id, titre, poster, overview, etc.).
* Ajout au panier : un film est ajouté à `$_SESSION['cart'][]`.
* Suppression : un élément est retiré via `unset($_SESSION['cart'][$index])`, éventuellement suivi de `array_values()` pour réindexer.

### 3. Achats

* Lors de la validation du panier, les films sont insérés dans la table `purchases` avec l’`user_id`.
* Une fois l’insertion effectuée, le panier est vidé.
* L’utilisateur peut ensuite consulter ses achats (par exemple depuis la page profil).

### 4. Profil utilisateur

* La page profil affiche les informations de l’utilisateur connecté.
* Un formulaire contient : username, nom complet, email, mot de passe.
* Le formulaire est désactivé par défaut (`disabled` sur les champs).
* Un switch (input type="checkbox" avec classe Bootstrap `form-switch`) permet d’activer/désactiver l’édition.
* En JavaScript, un listener sur le switch active/désactive les champs et le bouton de sauvegarde.

## Licence

Projet à vocation éducative.
Libre d’utilisation et de modification dans un cadre d’apprentissage ou de démonstration.
