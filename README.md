# <h1 align="center">👨‍💻 Symfony 7 👩‍💻</h1>

## Exemples de code
- database :
   - migration : [Version20240412111200.php](migrations/Version20240412111200.php)
   - fixture : [ArticleFixtures.php](src/DataFixtures/ArticleFixtures.php)
- entity : [Article.php](src/Entity/Article.php)
- repository : [ArticleRepository.php](src/Repository/ArticleRepository.php)
- eventListener - request : [LocaleListener.php](src/EventListener/LocaleListener.php)
- template : [index.html.twig](templates/article/index.html.twig)
- classe formulaire : [ArticleType.php](src/Form/ArticleType.php)
- controller : [ArticleController.php](src/Controller/ArticleController.php)
- service : [FileUploader.php](src/Service/FileUploader.php)
- command : [GetJokeCommand.php](src/Command/GetJokeCommand.php)
- envoi d'un email : [EmailController.php](src/Controller/EmailController.php)
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
- compléter le fichier de l'entité généré (ex. ajouter un unique)

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
    - commande : 
        - création : `php bin/console make:command`
        - lancement : `php bin/console app:get-joke`
    - email : 
        - tester l'envoi sans code : `php bin/console mailer:test someone@example.com`
        - consommer les messages : `php bin/console messenger:consume async`
        - consommer un seul message : `php bin/console messenger:consume async --limit 1`
    
## 4) Extensions
- TWIG pack de Bajdzis

## 5) Autres
- un fichier se trouvant dans src/... doit avoir comme namespace App\...
- exécuter du code avant d'appeler une route : il faut créer un listener sur kernel.request
- dans la documentation certaines pages affichent une version antérieure, tant qu'elle est maintenu on peut s'en servir
- config\packages\security.yaml :
    - password_hashers : on peut ajouter une classe pour que Symfony hashe automatiquement le mot de passe (si l'attribut est != de "password" il faudra le paramètrer)
    - providers : listes des fournisseurs utilisateurs. Chaque fournisseur indique ou charger les utilisateurs et par quoi les authentifier
    - firewalls : 
        - dev : définition des accès aux urls en env. dev
        - main : définit pour un provider user la façon de l'authentifier (ex. appel d'un formulaire ou d'une route)
    - access_control : définit l'accès à des routes selon le rôle utilisateur
    - when@test : permet de surcharger la config de sécurité avec des paramètres différents selon l'env.

## 6) Documentation
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
