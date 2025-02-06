# ENTRETIEN TECHNIQUE GPA

## Description

Ce projet est une application web développée avec [Symfony 7.2](https://symfony.com/), [PHP 8.3](https://www.php.net/), et [API Platform 4](https://api-platform.com/). L'application fournit une API RESTful pour gérer des ressources, avec des données factices générées pour les tests et le développement. Les tests unitaires sont écrits avec [PHPUnit](https://phpunit.de/).

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- PHP 8.3
- Composer 
- Symfony CLI
  
## Installation

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/votre-utilisateur/votre-repo.git
   cd votre-repo

   Basculer sur la branche development
   git checkout development

2. **Installer les dépendances PHP**

    ```bash
    composer install

4. **Créer la base de données et charger les données factices**
   
    ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load

4. **Démarrer le serveur Symfony**

    ```bash
    symfony server:start

## Utilisation

**API Endpoints**
  L'API est documentée automatiquement via API Platform. Vous pouvez accéder à la documentation de l'API à l'adresse suivante :
Documentation de l'API : http://localhost:8000/api

**Données Factices**
Des données factices ont été générées et chargées dans la base de données via les fixtures Doctrine. Vous pouvez utiliser ces données pour tester l'application.

**Tests**
Les tests sont écrits avec PHPUnit. Pour exécuter les tests, utilisez la commande suivante :

    ```bash
    php bin/phpunit

   
