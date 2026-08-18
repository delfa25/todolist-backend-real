# 📝 ToDoList Backend - Laravel 12 API

[![Laravel CI/CD](https://github.com/yourusername/todolist-backend-laravel/workflows/Laravel%20CI/CD/badge.svg)](https://github.com/yourusername/todolist-backend-laravel/actions)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.0+-red.svg)](https://laravel.com)

## 🎯 Description

Backend API pour l'application ToDoList développé avec **Laravel 12** dans le cadre d'un projet DevOps. Cette API REST fournit toutes les fonctionnalités CRUD nécessaires pour gérer les tâches.

## 🚀 Fonctionnalités

- ✅ **API REST complète** pour les tâches (CRUD)
- ✅ **Modèle Task** avec validation
- ✅ **Tests unitaires** avec PHPUnit (14 tests passent)
- ✅ **Migration MySQL** pour la persistance
- ✅ **CI/CD** avec GitHub Actions
- ✅ **Déploiement** sur Render/Railway

## 📚 API Endpoints

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| `GET` | `/api/tasks` | Récupérer toutes les tâches |
| `POST` | `/api/tasks` | Créer une nouvelle tâche |
| `GET` | `/api/tasks/{id}` | Récupérer une tâche spécifique |
| `PUT` | `/api/tasks/{id}` | Mettre à jour une tâche |
| `DELETE` | `/api/tasks/{id}` | Supprimer une tâche |

## 🛠️ Installation locale

```bash
# Cloner le repository
git clone https://github.com/yourusername/todolist-backend-laravel.git
cd todolist-backend-laravel

# Installer les dépendances
composer install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate

# Démarrer le serveur
php artisan serve
```

L'API sera disponible sur `http://localhost:8000`

## 🐳 Docker

### Services disponibles
- **app**: Application Laravel (PHP 8.2-FPM et Nginx dans le même conteneur)
- **db**: Base de données MySQL 8.0

### Commandes Docker utiles
```bash
# Démarrer le conteneur du backend (Nginx et PHP-FPM inclus)
docker build -t todolist-backend .
docker run -p 80:80 -p 3306:3306 --name todolist-backend-container -d todolist-backend

# Alternative avec docker-compose si vous voulez aussi MySQL localement
# (Assurez-vous d'avoir un docker-compose.yml approprié)
# docker-compose up -d

# Voir les logs
docker logs -f todolist-backend-container

# Accéder au conteneur de l'application
docker exec -it todolist-backend-container bash

# Arrêter et supprimer le conteneur
docker stop todolist-backend-container
docker rm todolist-backend-container
```

## 🧪 Tests

```bash
php artisan test
```

## 🚀 CI/CD avec GitHub Actions

Le projet inclut un workflow GitHub Actions complet :
- ✅ **Tests automatisés** avec PHPUnit
- ✅ **Build** de l'application
- ✅ **Déploiement** sur Render/Railway

## 🌐 Déploiement

### Render
1. Connectez votre repository GitHub à Render
2. Configurez les variables d'environnement :
   - `DB_CONNECTION=mysql`
   - `DB_HOST=your-mysql-host`
   - `DB_DATABASE=your-database`
   - `DB_USERNAME=your-username`
   - `DB_PASSWORD=your-password`
3. Déployez automatiquement
