# 🖥️ Alizon

![Language](https://img.shields.io/badge/Language-HTML-ff993f)
![Language](https://img.shields.io/badge/Language-CSS-3fb8ff)
![Language](https://img.shields.io/badge/Language-JavaScript-ffcc14)
![Language](https://img.shields.io/badge/Language-PHP-474A8A)
![Language](https://img.shields.io/badge/Language-MYSQL-62c2d7)
![Language](https://img.shields.io/badge/Language-Docker-1da9ea)
![Size](https://img.shields.io/badge/Size-122Mo-f12222)
![Open Source](https://badges.frapsoft.com/os/v2/open-source.svg?v=103)


Bienvenue dans le projet Alizon, un site e-commerce basé sur PHP, MySQL et Apache, entièrement conteneurisé avec Docker.

## 📌 1. Prérequis

Avant de commencer, assurez-vous d’avoir installé :

- Docker
- Docker Compose

## 🛠 2. Installation et Configuration

### 1️⃣ Cloner le projet

    git clone https://github.com/LucasVaugrente/Alizon/alizon.git
    cd alizon

### 2️⃣ Configurer les variables d’environnement

Crée un fichier **.env** à la racine du projet :

    MYSQL_ROOT_PASSWORD=root
    MYSQL_DATABASE=alizon
    MYSQL_USER=votre_nom
    MYSQL_PASSWORD=votre_mot_de_passe
    MYSQL_HOST=alizon_mysql
    MYSQL_PORT=3306

## 🚀 3. Lancer les conteneurs

    docker-compose up -d --build

## 🔍 4. Accès aux services

Site Web : http://localhost:8080

## 🚀 5. Arrêter les conteneurs

    docker-compose down

Si vous voulez aussi supprimer les données MySQL :

    docker-compose down -v


# 🙎‍♂️ Crédits
* [Lucas Vaugrente](https://github.com/LucasVaugrente "Mon compte GitHub")