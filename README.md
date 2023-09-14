README.md
#Bibliothèque

Ce repo contient une application de gestion de bibliothèque.
Il s'agit d'un ecf pour la promo 11.

## Prérequis

- Linux, MacOS, Windows
- Bash
- PHP 8
- Composer
- Symfony-cli
- Mariadb 10
- Docker( optionnel)

## Installation

```
git clone https://github.com/sebastien-76/bibliotheque
cd bibliotheque
composer install

```
Créer une base de données et un utilisateur dédié pour cette base de données.

## Configuration

Créer un fichier `.env.local` à la racine du projet

```
APP_ENV=dev
APP_DEBUG=true
APP_SECRET=123
DATABASE_URL="mysql://bibliotheque:123@127.0.0.1:3306/bibliotheque?serverVersion=mariadb-10.6.12&charset=utf8mb4"
```

Penser  à changer la variable `APP_SECRET` et les codes d'accès dans la varaible `DATABASE_URL`.

## Migration et fixtures

Pour que l'application soit utilisable, il faut créer le schéma de la base de données et charger les données.

```
bin/dofilo.sh
```




**ATTENTION : `APP_SECRET` doit être une chaîne de caractère de 32 caractères en hexadécimal.**

## Utilisation

Lancer le serveur web de développement :

```
symfony serve
```

Puis ouvrir la page suivante : [https://localhost:8000](https://localhost:8000)

Pour vérifier les requêtes en lecture pour les users, ouvrir la page :
[https://localhost:8000/test/user](https://localhost:8000/test/user)

Pour vérifier les requêtes en lecture pour les livres, ouvrir la page :
[https://localhost:8000/test/livre](https://localhost:8000/test/livre)

Pour vérifier les requêtes en lecture pour les emprunteurs, ouvrir la page :
[https://localhost:8000/test/emprunteur](https://localhost:8000/test/emprunteur)

Pour vérifier les requêtes en lecture pour les emprunts, ouvrir la page :
[https://localhost:8000/test/emprunt](https://localhost:8000/test/emprunt)

## Mentions légales

Ce projet est sous licence MIT.

La licence est disponible ici : [MIT LICENCE](LICENCE)
