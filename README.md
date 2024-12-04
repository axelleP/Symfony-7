# <h1 align="center">👨‍💻 Symfony 7 - Quick Guide  👩‍💻</h1> 

<details>
  <summary><h2>Français</h2></summary>

## [🚀 Aperçu rapide - exemples de code 🚀]
- database :
   - migration : [Version20240412111200.php](migrations/Version20240412111200.php)
   - fixture : [ArticleFixtures.php](src/DataFixtures/ArticleFixtures.php)
- entity : [Article.php](src/Entity/Article.php)
- repository : [ArticleRepository.php](src/Repository/ArticleRepository.php)
- form classes : [ArticleType.php](src/Form/ArticleType.php)
- controller : [ArticleController.php](src/Controller/ArticleController.php)
- template : [index.html.twig](templates/article/list.html.twig)
- eventListener - request : [LocaleListener.php](src/EventListener/LocaleListener.php)
- command - HTTP client - cache : [GetJokeCommand.php](src/Command/GetJokeCommand.php)
- session : Ligne 23 - [UserController.php](src/Controller/UserController.php) 
- service : [FileUploader.php](src/Service/FileUploader.php)
- email - log : [EmailController.php](src/Controller/EmailController.php)
- test functional : [LoginTest.php](tests/Functional/LoginTest.php)

## [📚 Détail 📚]
### 1) Lancement
Environnement :       
- PHP : >=8.2      
- MySQL : 8.0.27      

Démarrage : `symfony server:start` => site accessible sur http://localhost:8000/       
Arrêt : `symfony server:stop`       

### 2) Configuration
- ajouter l'extension "TWIG pack" de Bajdzis sur son éditeur
- fichiers de configuration :
   - /config
   - .env, .env.test, ...
   - configurer la langue par défaut du site : config\packages\translation.yaml
- installation de fichiers :
    - `composer install`
    - personnaliser les pages d'erreurs : 
        - exécuter `composer require symfony/twig-pack`
        - redéfinir les pages dans templates\bundles\TwigBundle\Exception\...
    - utiliser des filtres Twig : 
        - date, nombre : `composer require twig/intl-extra`
        - chaîne : `composer require twig/string-extra`
      

Plus de détails dans config\packages\security.yaml :
- password_hashers : on peut ajouter une classe pour que Symfony hashe automatiquement le mot de passe (si l'attribut est != de "password" il faudra le paramètrer)
- providers : listes des fournisseurs utilisateurs. Chaque fournisseur indique ou charger les utilisateurs et par quoi les authentifier
- firewalls : 
    - dev : définition des accès aux urls en env. dev
    - main : définit pour un provider user la façon de l'authentifier (ex. appel d'un formulaire ou d'une route)
- access_control : définit l'accès à des routes selon le rôle utilisateur
- when@test : permet de surcharger la configuration avec des paramètres différents selon l'env.

### 3) Gestion d'une base de données 
Configuration :
- `composer require symfony/orm-pack`
- `composer require --dev symfony/maker-bundle`
- modifier DATABASE_URL dans son .env    

Création de la base :
- `php bin/console doctrine:database:create`     

Création d'une entité :
- `php bin/console make:entity`
- compléter le fichier de l'entité générée (ex. ajouter un unique)    

Gestion des migrations :
- créer une migration : `php bin/console make:migration`    
- exécuter les migrations : `php bin/console doctrine:migrations:migrate`    
- annuler la dernière migration : `php bin/console doctrine:migrations:migrate prev`     
- revenir à une migration spécifique : `php bin/console doctrine:migrations:migrate 'DoctrineMigrations\Version20240411143108'`     

### 4) Création d'un système d'authentification utilisateur
- `php bin/console make:user`
- compléter l'entité user si besoin en ligne de commande (`php bin/console make:entity`) et/ou dans le fichier src\Entity\User.php
- créer et exécuter la migration
- exécuter et remanier le code généré par `php bin/console make:security:form-login`
- plus d'infos : https://symfony.com/doc/current/security.html#authentication-identifying-logging-in-the-user

### 5) Commandes
- information :
    - lister les commandes disponibles : `php bin/console`
    - avoir le détail d'une commande en rajoutant `--help`. ex. : `php bin/console doctrine:fixtures:load --help`
    - lister les routes définies : `php bin/console debug:router`
- actions spécifiques :
    - nettoyer le cache : `php bin/console cache:clear`
    - lancer le sass : `php bin/console sass:build --watch`
- création :
    - CRUD (contrôleur/liste/vue/formulaire/...) pour une entité donnée : `php bin/console make:crud`
    - contrôleur : `php bin/console make:controller HomeController`
    - modèle : `php bin/console make:entity`
    - formulaire dans une classe : `php bin/console make:form`
    - listener sur les requêtes : `php bin/console make:listener LocaleListener` puis choisir `kernel.request`
    - données de tests : 
        - installer la bibliothèque fixture : `composer require orm-fixtures --dev`
        - utiliser faker : `composer require fakerphp/faker`
        - créer une fixture : `php bin/console make:fixture`
        - lancer les fixtures :
            - supprime d'abord toutes les données en base : `php bin/console doctrine:fixtures:load`
            - conserve toutes les données en base : `php bin/console doctrine:fixtures:load --append`
        - lancer les fixture appartenant à un groupe spécifique : `php bin/console doctrine:fixtures:load --group=user` (voir la doc pour configurer la classe fixture)
- commande : 
    - création : `php bin/console make:command`
    - lancement : `php bin/console app:get-joke`
- email : 
    - tester l'envoi sans code : `php bin/console mailer:test someone@example.com`
    - consommer les messages : `php bin/console messenger:consume async`
    - consommer un seul message : `php bin/console messenger:consume async --limit 1`
- tests : Attention il faut une base de données de test (ex. : symfony_7_guide_test)
    - configurer son .env.test
    - créer un test : `php bin/console make:test` 
    - lancer les tests : `php bin/phpunit`

### 6) Bundle
#### 1. FOSCKEditorBundle
Utilisations possibles :    
- sans licence en installant la version 4.22.0
- avec la licence GPL en open source (gratuit avec inscription)
- avec une licence commerciale pour plus de fonctionnalités

Installation :    
- `composer require friendsofsymfony/ckeditor-bundle` avec l'option yes
- version sans licence : `php bin/console ckeditor:install --tag=4.22.0` avec l'option drop
- si on utilise Symfony flex : `php bin/console assets:install public`

Documentation :
- installation : https://symfony.com/bundles/FOSCKEditorBundle/current/installation.html
- utilisation : https://symfony.com/bundles/FOSCKEditorBundle/current/index.html

### 7) Compléments
- un fichier se trouvant dans src/... doit avoir comme namespace App\\...

### 8) Documentation
Certaines pages affichent une version antérieure de symfony, tant qu'elles sont maintenues on peut s'en servir.     
Privilégier d'abord l'overview puis la barre de recherche (taper le début du mot pour élargir le résultat ou taper avec 1 ou 2 mots-clés entier).      
Ne pas hésiter à aller directement sur le site des bibliothèques si possible.     

- Symfony : https://symfony.com/doc/current/index.html
- variables globales accessibles : https://symfony.com/doc/current/templates.html#the-app-global-variable 
- doctrine : https://symfony.com/doc/current/doctrine.html (entity, migration, récupération et manipulation des données, ...)
    - configuration base de données : https://symfony.com/doc/current/doctrine.html#configuring-the-database
    - mapping : https://www.doctrine-project.org/projects/doctrine-orm/en/3.1/reference/basic-mapping.html
- Twig - filtre : https://twig.symfony.com/doc/3.x/filters/index.html
- form - type de champs et options : https://symfony.com/doc/current/reference/forms/types.html
- envoyer/consommer des messages (email, sms, ...) : https://symfony.com/doc/current/messenger.html
</details>

<!-- ANGLAIS -->

<details>
  <summary><h2>English</h2></summary>

## [🚀 Quick overview - code examples 🚀]
- database :
   - migration : [Version20240412111200.php](migrations/Version20240412111200.php)
   - fixture : [ArticleFixtures.php](src/DataFixtures/ArticleFixtures.php)
- entity : [Article.php](src/Entity/Article.php)
- repository : [ArticleRepository.php](src/Repository/ArticleRepository.php)
- form classes : [ArticleType.php](src/Form/ArticleType.php)
- controller : [ArticleController.php](src/Controller/ArticleController.php)
- template : [index.html.twig](templates/article/list.html.twig)
- eventListener - request : [LocaleListener.php](src/EventListener/LocaleListener.php)
- command - HTTP client - cache : [GetJokeCommand.php](src/Command/GetJokeCommand.php)
- session : Line 23 - [UserController.php](src/Controller/UserController.php) 
- service : [FileUploader.php](src/Service/FileUploader.php)
- email - log : [EmailController.php](src/Controller/EmailController.php)
- test functional : [LoginTest.php](tests/Functional/LoginTest.php)

## [📚 Detail 📚]
### 1) Launch
Environment :       
- PHP : >=8.2      
- MySQL : 8.0.27      

Start : `symfony server:start` => website accessible on http://localhost:8000/       
Stop : `symfony server:stop`       

### 2) Configuration
- add the Bajdzis "TWIG pack" extension to its editor
- configuration files :
   - /config
   - .env, .env.test, ...
   - configure the site's default language : config\packages\translation.yaml
- file installation :
    - `composer install`
    - customise error pages : 
        - execute `composer require symfony/twig-pack`
        - redefine pages in templates\bundles\TwigBundle\Exception\...
    - use Twig filters : 
        - date, number : `composer require twig/intl-extra`
        - string : `composer require twig/string-extra`
      

More details in config\packages\security.yaml :
- password_hashers : you can add a class so that Symfony automatically hashes the password (if the attribute is != of "password" you'll need to set it)
- providers : lists of user providers. Each provider indicates where to load users and how to authenticate them
- firewalls : 
    - dev : definition of access to urls in dev env.
    - main : defines how a provider user is to be authenticated (e.g. by calling a form or a route)
- access_control : defines access to routes according to user role
- when@test : allows the configuration to be overloaded with different parameters depending on the env.

### 3) Database management
Configuration :
- `composer require symfony/orm-pack`
- `composer require --dev symfony/maker-bundle`
- modify DATABASE_URL in its .env file    

Database creation :
- `php bin/console doctrine:database:create`     

Entity creation :
- `php bin/console make:entity`
- complete the generated entity file (e.g. add a unique) 

Migration management :
- migration creation : `php bin/console make:migration`    
- execute migrations : `php bin/console doctrine:migrations:migrate`    
- cancel the last migration : `php bin/console doctrine:migrations:migrate prev`     
- return to a specific migration : `php bin/console doctrine:migrations:migrate 'DoctrineMigrations\Version20240411143108'`     

### 4) Creation of a user authentication system
- `php bin/console make:user`
- complete the user entity if necessary on the command line (`php bin/console make:entity`) and/or in the src\Entity\User.php file
- create and execute the migration
- execute and refactor the code generated by `php bin/console make:security:form-login`
- more info : https://symfony.com/doc/current/security.html#authentication-identifying-logging-in-the-user

### 5) Commands
- information :
    - list available commands : `php bin/console`
    - get the details of a command by adding `--help`. e.g.: `php bin/console doctrine:fixtures:load --help`.
    - list defined routes : `php bin/console debug:router`
- specific actions :
    - clean the cache : `php bin/console cache:clear`
    - launch the sass : `php bin/console sass:build --watch`
- creation :
    - CRUD (controller/list/view/form/...) for a given entity : `php bin/console make:crud`
    - controller : `php bin/console make:controller HomeController`
    - model : `php bin/console make:entity`
    - form in a class  : `php bin/console make:form`
    - listener on requests : `php bin/console make:listener LocaleListener` then choose `kernel.request`
    - test data : 
        - install the fixture library : `composer require orm-fixtures --dev`
        - use faker : `composer require fakerphp/faker`
        - create a fixture : `php bin/console make:fixture`
        - launch fixtures :
            - first deletes all the data in the database : `php bin/console doctrine:fixtures:load`
            - preserve  all data in database : `php bin/console doctrine:fixtures:load --append`
        - launch fixtures belonging to a specific group : `php bin/console doctrine:fixtures:load --group=user` (see the documentation for configuring the fixture class)
- command : 
    - creation : `php bin/console make:command`
    - launch : `php bin/console app:get-joke`
- email : 
    - test sending without code : `php bin/console mailer:test someone@example.com`
    - consume messages : `php bin/console messenger:consume async`
    - consume a single message : `php bin/console messenger:consume async --limit 1`
- tests : Please note that you need a test database (e.g. symfony_7_guide_test).
    - configure its .env.test
    - create a test : `php bin/console make:test` 
    - launch tests : `php bin/phpunit`

### 6) Bundle
#### 1. FOSCKEditorBundle
Possible uses :    
- without licence by installing version 4.22.0
- with an open source GPL licence (free with registration)
- with a commercial licence for more functions

Installation :    
- `composer require friendsofsymfony/ckeditor-bundle` with the yes option
- unlicensed version : `php bin/console ckeditor:install --tag=4.22.0` with the drop option
- if you use Symfony flex : `php bin/console assets:install public`

Documentation :
- installation : https://symfony.com/bundles/FOSCKEditorBundle/current/installation.html
- use : https://symfony.com/bundles/FOSCKEditorBundle/current/index.html

### 7) Complements
- a file located in src/... must have App\\... as its namespace

### 8) Documentation
Some pages display an earlier version of symfony, but as long as they are maintained, you can use them.     
Use the overview first, then the search bar (type the beginning of the word to broaden the result or type in 1 or 2 whole keywords).      
Don't hesitate to go directly to the library website if possible.        

- Symfony : https://symfony.com/doc/current/index.html
- accessible global variables : https://symfony.com/doc/current/templates.html#the-app-global-variable 
- doctrine : https://symfony.com/doc/current/doctrine.html (entity, migration, data recovery and handling, etc.)
    - database configuration : https://symfony.com/doc/current/doctrine.html#configuring-the-database
    - mapping : https://www.doctrine-project.org/projects/doctrine-orm/en/3.1/reference/basic-mapping.html
- Twig - filter : https://twig.symfony.com/doc/3.x/filters/index.html
- form - field types and options : https://symfony.com/doc/current/reference/forms/types.html
- send/consume messages (email, sms, etc.) : https://symfony.com/doc/current/messenger.html
</details>