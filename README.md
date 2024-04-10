# <h1 align="center">👨‍💻 Entraînement Symfony 7 👩‍💻</h1>

## Exemples de code

___

## 1) Lancement
Lancer WampServer avec PHP à partir de la version 8.2.    

Exécuter `symfony server:start` et se rendre sur http://localhost:8000/        

## 2) Configuration
- /config
- .env
- `composer install`
- langue par défaut du site : config\packages\translation.yaml
- personnaliser les pages d'erreurs : 
    - exécuter `composer require symfony/twig-pack`
    - redéfinir les pages dans templates\bundles\TwigBundle\Exception\...

### Créer la base de données 
Création de la base :
- `composer require symfony/orm-pack`
    - `composer require --dev symfony/maker-bundle`
    - configurer la connexion et le nom de la bdd dans son .env
    - `php bin/console doctrine:database:create`

Création d'une entité :
- `php bin/console make:entity`
- commpléter le fichier de l'entité générée (ex. ajouter un unique)

Création d'une migration : `php bin/console make:migration`
Exécution des migrations : `php bin/console doctrine:migrations:migrate`

## 3) Commandes
- nettoyer le cache : php bin/console cache:clear
- liste des commandes disponibles : `php bin/console`
- exemples commandes :
    - liste des routes définies : `php bin/console debug:router`
    - créer un contrôleur : `php bin/console make:controller HomeController`
    - créer un listener sur les requêtes : `php bin/console make:listener LocaleListener` puis choisir kernel.request
    - créer un modèle : `php bin/console make:entity`
    - créer des données de tests : 
        - installer la bibliothèque : `composer require orm-fixtures --dev`
        - créer une fixture : `php bin/console make:fixture`
        - lancer les fixtures : `php bin/console doctrine:fixtures:load` ⚠️ les données en bdd sont effacées

## 4) Extensions
- TWIG pack de Bajdzis

## 5) Autres
- un fichier se trouvant dans src/... doit avoir comme namespace App\...
- exécuter du code avant d'appeler une route : il faut créer un listener sur kernel.request
- dans la documentation certaines pages affichent une version antérieure, tant qu'elle est maintenu on peut s'en servir

## 6) Documentation
- Symfony : https://symfony.com/doc/current/index.html
    - variables globales accessibles : https://symfony.com/doc/current/templates.html#the-app-global-variable 
    - configurer la base de données : https://symfony.com/doc/current/doctrine.html#configuring-the-database