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

## 3) Commandes
- nettoyer le cache : php bin/console cache:clear
- liste des commandes disponibles : `php bin/console`
    - ex. créer un contrôleur : `symfony console make:controller HomeController`
- liste des routes définies : `php bin/console debug:router`

## 4) Extensions
- TWIG pack de Bajdzis

## 5) Définitions


## 6) Documentation
- Symfony : https://symfony.com/doc/current/index.html
    - variables globales accessibles : https://symfony.com/doc/current/templates.html#the-app-global-variable 