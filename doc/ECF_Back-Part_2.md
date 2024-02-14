# ECF Back - Part 2 - Projet bibliothèque - Composants d'accès aux données

Le but de cet exercice est de maitriser l'utilisation de composants d'accès aux données d'une application web dynamique.

Note : cet exercice prolonge l'exercice de création de BDD.

## Cahier des charges

Vous devez utiliser des composants d'accès aux données qui réalise les requêtes indiquées plus bas.

Attention : l'accès à la BDD doit être effectué via un unique utilisateur ayant été créé à cet effet.

Vous pouvez utiliser les composants d'accès au données de votre choix : PHP vanila, Doctrine (Symfony) ou Eloquent (Laravel) par exemple.
Mais vous êtes vivement encouragé à utiliser Doctrine.

## Livrables

Le code doit être livré sous la forme d'un repository git en ligne sur un site comme github, gitlab ou autre.

Vous avez deux options : 1) vous utilisez les composants d'accès aux données d'un framework PHP ou 2) vous n'utilisez aucun framework PHP.

Quelque soit votre choix, le repository git doit contenir les fichiers suivants :

- un fichier `README.md` (voir ci-dessous)
- un ou des fichiers PHP contenant des requêtes qui utilisent des composants d'accès aux données

Le fichier `README.md` doit indiquer la procédure à suivre pour :

- si nécessaire, installer les dépendances (avec `composer` par exemple)
- lancer le serveur web
- montrer l'URL à ouvrir pour tester les requêtes d'accès aux données

Attention : en fonction de vos données de test, il se peut que certaines requêtes ne renvoient aucunes données.
Dans ce cas, ne vous inquiétez pas.
Ce qui est évalué, c'est le fonctionnement correct des requêtes, pas la présence ou l'absence de résultats.

## Prérequis

- MariaDB
- PHPMyAdmin
- la BDD du projet bibliothèque

Si vous utilisez Symfony :

- PHP 8.x
- composer

## Le contrôleur

Si vous utilisez Symfony, toutes les requêtes doivent être créées dans un contrôleur nommé `TestController`.

## Les requêtes

Attention : une partie des données étant générées aléatoirement, il se peut que certaines requêtes en lecture ne donnent aucun résultat.
Ce n'est pas parce qu'une requête ne renvoie aucun résultat qu'elle ne fonctionne pas.
C'est à vous de vérifier si le résultat est correct en requêtant « à la main » la BDD (avec PHPMyAdmin par exemple).

### Les utilisateurs

Requêtes de lecture :

- la liste complète de tous les utilisateurs (de la table `user`), triée par ordre alphabétique d'email
- l'unique utilisateur dont l'id est `1`
- l'unique utilisateur dont l'email est exactement `foo.foo@example.com`
- la liste des utilisateurs dont l'attribut `roles` contient le mot clé `ROLE_USER`, triée par ordre alphabétique d'email
- la liste des utilisateurs inactifs (c-à-d dont l'attribut `enabled` est égal à `false`), triée par ordre alphabétique d'email

Si vous utilisez Symfony, toutes les requêtes doivent être créées dans la route `/test/user`.

### Les livres

Requêtes de lecture :

- la liste complète de tous les livres, triée par ordre alphabétique de titre
- l'unique livre dont l'id est `1`
- la liste des livres dont le titre contient le mot clé `lorem`, triée par ordre alphabétique de titre
- la liste des livres dont l'id de l'auteur est `2`, triée par ordre alphabétique de titre
- la liste des livres dont le genre contient le mot clé `roman`, triée par ordre alphabétique de titre

Requêtes de création :

- ajouter un nouveau livre
  - titre : Totum autem id externum
  - année d'édition : 2020
  - nombre de pages : 300
  - code ISBN : 9790412882714
  - auteur : Hugues Cartier (id `2`)
  - genre : science-fiction (id `6`)

Requêtes de mise à jour :

- modifier le livre dont l'id est `2`
  - titre : Aperiendum est igitur
  - genre : roman d'aventure (id `5`)

Requêtes de suppression :

- supprimer le livre dont l'id est `123`

Si vous utilisez Symfony, toutes les requêtes doivent être créées dans la route `/test/livre`.

### Les emprunteurs

Requêtes de lecture :

- la liste complète des emprunteurs, triée par ordre alphabétique de nom et prénom
- l'unique emprunteur dont l'id est `3`
- l'unique emprunteur qui est relié au user dont l'id est `3`
- la liste des emprunteurs dont le nom ou le prénom contient le mot clé `foo`, triée par ordre alphabétique de nom et prénom
- la liste des emprunteurs dont le téléphone contient le mot clé `1234`, triée par ordre alphabétique de nom et prénom
- la liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit), triée par ordre alphabétique de nom et prénom

Si vous utilisez Symfony, toutes les requêtes doivent être créées dans la route `/test/emprunteur`.

### Les emprunts

Requêtes de lecture :

- la liste des 10 derniers emprunts au niveau chronologique, triée par ordre **décroissant** de date d'emprunt (le plus récent en premier)
- la liste des emprunts de l'emprunteur dont l'id est `2`, triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)
- la liste des emprunts du livre dont l'id est `3`, triée par ordre **décroissant** de date d'emprunt (le plus récent en premier)
- la liste des 10 derniers emprunts qui ont été retournés, triée par ordre **décroissant** de date de retour (le plus récent en premier)
- la liste des emprunts qui n'ont pas encore été retournés (c-à-d dont la date de retour est nulle), triée par ordre **croissant** de date d'emprunt (le plus ancien en premier)
- l'unique emprunt relié au livre dont l'id est `3`

Requêtes de création :

- ajouter un nouvel emprunt
  - date d'emprunt : 01/12/2020 à 16h00
  - date de retour : aucune date
  - emprunteur : foo foo (id `1`)
  - livre : Lorem ipsum dolor sit amet (id `1`)

Requêtes de mise à jour :

- modifier l'emprunt dont l'id est `3`
  - date de retour : 01/05/2020 à 10h00

Requêtes de suppression :

- supprimer l'emprunt dont l'id est `42`

Si vous utilisez Symfony, toutes les requêtes doivent être créées dans la route `/test/emprunt`.
