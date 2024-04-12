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
- pouvoir utiliser les filtres de Twig : 
    - date, nombre : `composer require twig/intl-extra`
    - chaîne : `composer require twig/string-extra`

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

### Créer un système d'authentification utilisateur
- `php bin/console make:user`
- compléter l'entité user si besoin en ligne de commande (`php bin/console make:entity`) et/ou dans le fichier src\Entity\User.php
- créer et exécuter la migration
- exécuter et remanier le code généré par `php bin/console make:security:form-login`
- plus d'infos : https://symfony.com/doc/current/security.html#authentication-identifying-logging-in-the-user

## 3) Commandes
- nettoyer le cache : `php bin/console cache:clear`
- liste des commandes disponibles : `php bin/console`
- avoir le détail d'une commande en rajoutant `--help`. ex. : `php bin/console doctrine:fixtures:load --help`
- exemples commandes :
    - liste des routes définies : `php bin/console debug:router`
    - créer automatiquement contrôleur/liste/vue/formulaire/... (CRUD) pour une entité donnée : `php bin/console make:crud`
    - créer un contrôleur : `php bin/console make:controller HomeController`
    - créer un modèle : `php bin/console make:entity`
    - créer un formulaire dans une classe : `php bin/console make:form`
    - créer des données de tests : 
        - installer la bibliothèque : `composer require orm-fixtures --dev`
        - créer une fixture : `php bin/console make:fixture`
        - lancer les fixtures : `php bin/console doctrine:fixtures:load` ou `php bin/console doctrine:fixtures:load --append` pour ne pas supprimer les données existantes
    - créer un listener sur les requêtes : `php bin/console make:listener LocaleListener` puis choisir `kernel.request`
    
## 4) Extensions
- TWIG pack de Bajdzis

## 5) Autres
- un fichier se trouvant dans src/... doit avoir comme namespace App\...
- exécuter du code avant d'appeler une route : il faut créer un listener sur kernel.request
- dans la documentation certaines pages affichent une version antérieure, tant qu'elle est maintenu on peut s'en servir

## 6) Documentation
- Symfony : https://symfony.com/doc/current/index.html
- variables globales accessibles : https://symfony.com/doc/current/templates.html#the-app-global-variable 
- doctrine : https://symfony.com/doc/current/doctrine.html (entity, migration, récupération et manipulation des données, ...)
    - configuration base de données : https://symfony.com/doc/current/doctrine.html#configuring-the-database
    - liste des types des propriétés : https://www.doctrine-project.org/projects/doctrine-orm/en/3.1/reference/basic-mapping.html
- Twig :
    - filtre : https://twig.symfony.com/doc/3.x/filters/index.html
    - type de champs et options : https://symfony.com/doc/current/reference/forms/types.html