# Projet E-commerce Symfony avec Docker

Ce projet est une application e-commerce basée sur Symfony, utilisant Docker pour la gestion de l'environnement de développement.

## Configuration du projet

1. Clonez le repository

## Prérequis

- Docker
- Docker Compose
- Git

## Structure des conteneurs

- **PHP (e-commerce-php-1)**: Contient l'application Symfony
- **Nginx (e-commerce-nginx-1)**: Serveur web, accessible sur le port 8080
- **PostgreSQL (e-commerce-database-1)**: Base de données, accessible sur le port 32773
- **Mailpit (e-commerce-mailer-1)**: Service de mail pour le développement

## Commandes utiles

- Démarrer les conteneurs : `docker-compose up -d`
- Arrêter les conteneurs : `docker-compose down`
- Voir les logs : `docker-compose logs`
- composer require symfony/notifier
- composer require symfony/mailer


## Accès aux services

- **Page d'accueil de l'application**: http://localhost:8080 ou http://127.0.0.1:8080
- **Base de données**: 
- Hôte: database
- Port: 5432
- Utilisateur: symfony (ou le nom d'utilisateur que vous avez défini dans docker-compose.yml)
- Mot de passe: password (ou le mot de passe que vous avez défini dans docker-compose.yml)
- **Mailpit**: http://localhost:32772


## Développement

1. Placez vos fichiers Symfony dans le répertoire racine du projet.
2. Les modifications seront automatiquement reflétées grâce au montage de volume.

## Base de données

Pour utiliser pgAdmin et gérer votre base de données PostgreSQL :

1. Accédez à pgAdmin via `http://localhost:5050`.
2. Connectez-vous avec les identifiants définis dans le `docker-compose.yml`.
3. Ajoutez un nouveau serveur avec les paramètres de connexion suivants :
 - Host: database
 - Port: 5432
 - Username: symfony (ou le nom d'utilisateur que vous avez défini)
 - Password: password (ou le mot de passe que vous avez défini)

## Côté Admin
Pour accéder à la section d'administration de l'application, veuillez utiliser les informations suivantes :
1. URL d'accès : /admin
2. Identifiants de connexion :
- Email : admin@example.com
-  Mot de passe : securepassword

## Dépannage

- Si vous ne pouvez pas accéder à l'application, vérifiez que tous les conteneurs sont en cours d'exécution : `docker-compose ps`
- Vérifiez les logs des conteneurs pour plus d'informations sur les erreurs potentielles : `docker-compose logs [service]`

