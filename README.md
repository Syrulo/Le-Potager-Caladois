Projet Symfony

Description :

Projet de fin d'études ayant été présenté lors de l'examen de développeur web / web mobile.

Ce projet est une application web utilisant Symfony destinée à mettre en contact des producteurs locaux avec des particuliers pour l'achat de produits. Il permet une visibilité accrue des producteurs sur internet et propose des fonctionnalités telles que :

Fonctionnalités principales

[✔] Authentification des utilisateurs

[✔] Possibilité pour un utilisateur de s'inscrire en tant que producteur

[✔] Gestion des articles ou produits par le producteur lui-même

Di vous souhaitez voir une démonstration en ligne via Heroku:

https://le-potager-caladois-473dbd9489eb.herokuapp.com/

Prérequis :

Avant d'installer et d'exécuter ce projet, assurez-vous d'avoir les éléments suivants installés sur votre machine :

PHP (>= 8.0)

Composer

Symfony CLI

MySQL ou PostgreSQL

Installation

Cloner le dépôt :

git clone https://github.com/Syrulo/Projet.git
cd Projet

Installer les dépendances :

composer install

Configurer la base de données :

Copier le fichier .env et renommer en .env.local

Modifier la ligne DATABASE_URL="mysql://user:password@127.0.0.1:3306/nom_de_la_db"

Créer la base de données et exécuter les migrations :

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

Lancer le serveur Symfony :

symfony server:start

L’application sera accessible via http://127.0.0.1:8000.

Utilisation :

Accéder à http://127.0.0.1:8000/

Se connecter avec un compte utilisateur que vous passez en rôle admin dans la base de données pour avoir accès au dashboard administrateur (par la suite vous pourrez attribuer un rôle admin à un utilisateur via ce même dashboard).

Technologies utilisées :

Symfony (Framework PHP)

Doctrine (ORM pour base de données)

Twig (Moteur de templates)

SGBD MySQL (Base de données)

JavaScript (Pour certaines fonctionnalités)

Bootstrap (Pour le design)

Améliorations futures :

Ajout d’un système de commentaires

Possibilité d'effectuer des achats en ligne

Déploiement sur un serveur distant

Auteur :

Thomas Borestel
