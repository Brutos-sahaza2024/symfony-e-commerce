# Projet E-commerce Symfony avec Docker

Ce projet est une application e-commerce basée sur Symfony, utilisant Docker pour la gestion de l'environnement de développement.

## Prérequis

- Docker
- Docker Compose
- Git

## Configuration du projet

1. Clonez le repository :

## Structure des conteneurs

- **PHP (e-commerce-php-1)**: Contient l'application Symfony
- **Nginx (e-commerce-nginx-1)**: Serveur web, accessible sur le port 8080
- **PostgreSQL (e-commerce-database-1)**: Base de données, accessible sur le port 32773
- **Mailpit (e-commerce-mailer-1)**: Service de mail pour le développement

## Accès aux services

- **Page d'accueil de l'application**: http://localhost:8080 ou http://127.0.0.1:8080
- **Base de données**: 
- Hôte: database
- Port: 5432
- Utilisateur: symfony (ou le nom d'utilisateur que vous avez défini)
- Mot de passe: password (ou le mot de passe que vous avez défini)
- **Mailpit**: http://localhost:32772

## Commandes utiles

- Démarrer les conteneurs : `docker-compose up -d`
- Arrêter les conteneurs : `docker-compose down`
- Voir les logs : `docker-compose logs`
- Exécuter des commandes Symfony :


## Développement

1. Placez vos fichiers Symfony dans le répertoire racine du projet.
2. Les modifications seront automatiquement reflétées grâce au montage de volume.

## Base de données

Pour utiliser pgAdmin et gérer votre base de données PostgreSQL :

1. Ajoutez le service pgAdmin à votre `docker-compose.yml` (voir la documentation pour les détails).
2. Accédez à pgAdmin via `http://localhost:5050`.
3. Connectez-vous avec les identifiants définis dans le `docker-compose.yml`.
4. Ajoutez un nouveau serveur avec les paramètres de connexion suivants :
 - Host: database
 - Port: 5432
 - Username: symfony (ou le nom d'utilisateur que vous avez défini)
 - Password: password (ou le mot de passe que vous avez défini)

## Dépannage

- Si vous ne pouvez pas accéder à l'application, vérifiez que tous les conteneurs sont en cours d'exécution : `docker-compose ps`
- Vérifiez les logs des conteneurs pour plus d'informations sur les erreurs potentielles : `docker-compose logs [service]`

## Contribution



## Licence


composer require symfony/notifier
composer require symfony/mailer
