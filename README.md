# Le Potager Caladois

🚧 **Projet en cours de développement** 🚧  
Ce projet n'est pas encore achevé. Certaines fonctionnalités peuvent être incomplètes ou en cours d'amélioration.

## Description :

Le Potager Caladois est une application web développée avec **Symfony** pour mettre en relation des producteurs locaux et des particuliers souhaitant acheter des produits agricoles. Il permet aux producteurs d'augmenter leur visibilité en ligne, ce qui est crucial pour ceux qui n'ont pas toujours les moyens de créer leur propre présence numérique. Ce projet soutient ainsi l'agriculture locale et l'achat responsable, tout en facilitant les échanges directs entre producteurs et consommateurs.

---

## Fonctionnalités principales :

- [✔] **Authentification des utilisateurs**
- [✔] **Possibilité pour un utilisateur de s'inscrire en tant que producteur**
- [✔] **Gestion des articles ou produits par le producteur lui-même**

---

## Installation :

Si vous souhaitez explorer plus en détail, suivez ces étapes pour installer le projet localement :

1. Clonez le dépôt : `git clone https://github.com/Syrulo/Projet.git`
2. Installez les dépendances avec Composer : `composer install`
3. Configurez la base de données en ajustant le fichier `.env.local`.
4. Lancez l'application localement : `symfony server:start`

---

## Technologies utilisées :

- **Symfony 7.2** (Framework PHP)
- **Doctrine** (ORM pour la gestion de base de données)
- **Twig** (moteur de templates)
- **MySQL** (base de données)
- **JavaScript** (Gestion des cookies, affichage sécurisé du mot de passe, etc.)
- **Bootstrap** (Framework CSS pour le design responsive)

---

## Défis rencontrés et solutions :

### 1. **Gestion des rôles utilisateurs** :
La mise en place d’un système d’administration permettant de définir différents rôles (producteurs, administrateurs) a nécessité la compréhension approfondie de la gestion des rôles et des permissions sous Symfony.

### 2. **Optimisation de la base de données** :
Pour gérer efficacement les produits et les transactions, j’ai optimisé les requêtes SQL avec **Doctrine** pour éviter des performances lentes à grande échelle.

---

## Améliorations futures :

- **Ajout d’un système de commentaires** pour renforcer la confiance des utilisateurs
- **Implémentation d'une fonctionnalité d'achat en ligne** pour permettre aux utilisateurs de passer commande directement via la plateforme.

---

## Auteur :

**Thomas Borestel**

## Contact :

N'hésitez pas à me contacter via une issue ou une discussion sur GitHub pour toute suggestion ou signalement de bug.
