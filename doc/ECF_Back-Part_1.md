# ECF Back - Part 1 - Projet bibliothèque - BDD

Le but de cet exercice est de maîtriser la création d'une base de données (BDD) qui sera utilisée dans une application web dynamique.

## Cahier des charges

Vous devez créer une BDD qui implémente la structure et les données indiquées plus bas.

Attention : l'accès à la BDD doit être limité à un unique utilisateur ayant le minimum possible de privilèges.

Pour créer la BDD, vous avez le choix des armes : SQL vanila, PHPMyAdmin, Doctrine (Symfony), Eloquent (Laravel), etc.
Mais vous êtes vivement encouragé à utiliser Symfony.

## Livrables

La BDD et les données doivent être livrées sous la forme d'un repository git en ligne sur un site comme github, gitlab ou autre.

Vous avez deux options : 1) vous créez la BDD en utilisant un framework PHP ou 2) vous la créez sans utiliser de framework PHP.

En fonction de votre choix, le repository git doit contenir les fichiers suivants :

1. avec framework PHP
  - un fichier `README.md` (voir ci-dessous)
  - un fichier image (photo ou schéma) qui représente visuellement le schéma de la structure de la BDD (méthode Merise ou UML au choix)
  - un ou des fichiers PHP contenant le code de création de la structure de la BDD
  - un ou des fichiers PHP contenant le code de création des données de test statiques et dynamiques
2. sans framework PHP
  - un fichier `README.md` (voir ci-dessous)
  - un fichier image (photo ou schéma) qui représente visuellement le schéma de la structure de la BDD (méthode Merise ou UML au choix)
  - un fichier SQL contenant le code de création de la structure de la BDD
  - un fichier SQL contenant les données de test statiques et dynamiques

Dans tous les cas, le fichier `README.md` doit indiquer la procédure à suivre pour :

- si nécessaire, installer les dépendances (avec `composer` par exemple)
- créer l'utilisateur de la BDD
- créer la BDD
- créer la structure de la BDD
- injecter les données de test statiques et dynamiques

Optionnellement, vous pouvez aussi fournir un script Bash qui réalise chacune de ces opérations.

## Prérequis

- MariaDB
- PHPMyAdmin

Si vous utilisez Symfony :

- PHP 8.x
- composer

## Structure de la BDD, données de test statiques et données de test dynamiques

### User

Attention : si vous utilisez Symfony, la création de l'entité `User` doit se faire avec la commande `php bin/console make:user` (et pas `php bin/console make:entity`).

Attributs :

- id : clé primaire
- email : varchar 190
- roles : text
- password : varchar 190
- enabled : boolean

Relations :

- emprunteur : one to one (l'emprunteur est le côté possédant, le user est le côté inverse)

#### Données de test statiques

Table `user` :

| id | email               | roles               | password                                                     | enabled |
|----|---------------------|---------------------|--------------------------------------------------------------|---------|
| 1  | admin@example.com   | ["ROLE_ADMIN"]      | ...                                                          | true    |
| 2  | foo.foo@example.com | ["ROLE_USER"]       | ...                                                          | true    |
| 3  | bar.bar@example.com | ["ROLE_USER"]       | ...                                                          | false   |
| 4  | baz.baz@example.com | ["ROLE_USER"]       | ...                                                          | true    |

Attention : le mot de passe clair est `123` mais vous devez utiliser une fonction de hachage pour stocker une version hachée du mot de passe.
Attention : si vous utilisez Symfony, vous pouvez utiliser la fonction de hachage `UserPasswordHasherInterface::hashPassword()` pour hacher le mot de passe.

#### Données de test dynamiques

100 users (`ROLE_USER`) dont les données sont générées aléatoirement.

### Genre

Attributs :

- id : clé primaire
- nom : varchar 190
- description : text, nullable

Relations :

- livres : many to many

#### Données de test statiques

Table `genre` :

| id | nom              | description |
|----|------------------|-------------|
| 1  | poésie           | NULL        |
| 2  | nouvelle         | NULL        |
| 3  | roman historique | NULL        |
| 4  | roman d'amour    | NULL        |
| 5  | roman d'aventure | NULL        |
| 6  | science-fiction  | NULL        |
| 7  | fantasy          | NULL        |
| 8  | biographie       | NULL        |
| 9  | conte            | NULL        |
| 10 | témoignage       | NULL        |
| 11 | théâtre          | NULL        |
| 12 | essai            | NULL        |
| 13 | journal intime   | NULL        |

#### Données de test dynamiques

Aucune

### Auteur

Attributs :

- id : clé primaire
- nom : varchar 190
- prenom : varchar 190

Relations :

- livres : one to many, nullable

#### Données de test statiques

Table `auteur` :

| id | nom            | prenom |
|----|----------------|--------|
| 1  | auteur inconnu |        |
| 2  | Cartier        | Hugues |
| 3  | Lambert        | Armand |
| 4  | Moitessier     | Thomas |

#### Données de test dynamiques

500 auteurs dont les données sont générées aléatoirement.

### Livre

Attributs :

- id : clé primaire
- titre : varchar 190
- annee_edition : int, nullable
- nombre_pages : int
- code_isbn : varchar 190, nullable

Relations :

- auteur : many to one
- genres : many to many
- emprunts : one to many

#### Données de test statiques

Table `livre` :

| id | titre                       | annee_edition | nombre_pages | code_isbn     | auteur_id |
|----|-----------------------------|---------------|--------------|---------------|-----------|
| 1  | Lorem ipsum dolor sit amet  | 2010          | 100          | 9785786930024 | 1         |
| 2  | Consectetur adipiscing elit | 2011          | 150          | 9783817260935 | 2         |
| 3  | Mihi quidem Antiochum       | 2012          | 200          | 9782020493727 | 3         |
| 4  | Quem audis satis belle      | 2013          | 250          | 9794059561353 | 4         |

Table `genre_livre` :

| livre_id | genre_id |
|----------|----------|
| 1        | 1        |
| 2        | 2        |
| 3        | 3        |
| 4        | 4        |

#### Données de test dynamiques

1000 livres dont les données sont générées aléatoirement.
Des relations avec les auteurs générées aléatoirement.
Des relations avec les genres générées aléatoirement.

### Emprunteur

Attributs :

- id : clé primaire
- nom : varchar 190
- prenom : varchar 190
- tel : varchar 190

Relations :

- emprunts : one to many
- user : one to one (l'emprunteur est le côté possédant, le user est le côté inverse)

#### Données de test statiques

Table `emprunteur` :

| id | nom | prenom | tel       | user_id |
|----|-----|--------|-----------|---------|
| 1  | foo | foo    | 123456789 | 2       |
| 2  | bar | bar    | 123456789 | 3       |
| 3  | baz | baz    | 123456789 | 4       |

#### Données de test dynamiques

100 emprunteurs dont les données sont générées aléatoirement.
Des relations avec les users générées aléatoirement.

### Emprunt

Attributs :

- id : clé primaire
- date_emprunt : datetime
- date_retour : datetime, nullable

Relations :

- emprunteur : many to one, not nullable
- livre : many to one, not nullable

#### Données de test statiques

Table `emprunt` :

| id | date_emprunt        | date_retour         | emprunteur_id | livre_id |
|----|---------------------|---------------------|---------------|----------|
| 1  | 2020-02-01 10:00:00 | 2020-03-01 10:00:00 | 1             | 1        |
| 2  | 2020-03-01 10:00:00 | 2020-04-01 10:00:00 | 2             | 2        |
| 3  | 2020-04-01 10:00:00 | NULL                | 3             | 3        |

#### Données de test dynamiques

200 emprunts dont les données sont générées aléatoirement.
Des relations avec les emprunteurs générées aléatoirement.
Des relations avec les livres générées aléatoirement.
