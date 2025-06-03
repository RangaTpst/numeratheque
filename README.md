
# 📚 Projet BTS SIO - Numérathèque

## 1. Présentation

Le projet **Numérathèque** est une application de gestion de bibliothèque en ligne développée dans le cadre de l'épreuve E5 du **BTS SIO** (SISR/SLAM).  
Elle permet aux utilisateurs de consulter, emprunter et gérer des livres à distance en toute sécurité.

Développée sous **Laravel 11**, utilisant une base de données **MySQL**, et compatible avec un déploiement sous **Debian 11** et **Windows WAMP**.

---

## 2. Fonctionnalités principales

- Consultation des livres disponibles avec leurs détails (titre, auteur, date de publication, catégorie).
- Emprunt et gestion des réservations de livres.
- Gestion des livres, des catégories et des emprunts pour les administrateurs.
- Gestion des utilisateurs et des droits d'accès.
- Upload et gestion des images de couverture des livres.
- Interface intuitive et réactive.
- Historique des emprunts pour chaque utilisateur.
- Blog / Actualités de la bibliothèque. (non implémenté)

---

## 3. Structure du projet

- **app/** : Contrôleurs, modèles, services (logique métier).
- **resources/** : Vues Blade, fichiers CSS et JS.
- **routes/** : Routes web de l'application.
- **storage/** : Fichiers générés, images uploadées.
- **tests/** : Tests unitaires et fonctionnels.

---

## 4. Installation

### 4.1. Guide d'installation Linux (Debian 11 + Nginx + PHP 8.3)

#### Prérequis

- PHP >= 8.3
- Composer
- MySQL/MariaDB
- Nginx
- Node.js (Vite pour assets)

#### Étapes

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y nginx mariadb-server php8.3 php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-bcmath php8.3-tokenizer unzip curl git nodejs npm
```

1. Cloner le projet :
```bash
git clone https://github.com/votre-username/numeratheque.git
cd numeratheque
```

2. Installer les dépendances :
```bash
composer install
npm install
```

3. Copier et configurer `.env` :
```bash
cp .env.example .env
nano .env
```

4. Générer la clé :
```bash
php artisan key:generate
```

5. Lancer les migrations :
```bash
php artisan migrate --seed
```

6. Compiler les assets :
```bash
npm run build
```

7. Configurer un vhost Nginx : `/etc/nginx/sites-available/numeratheque`

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/numeratheque/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Redémarrer Nginx :
```bash
sudo systemctl reload nginx
```

8. Installer SSL :
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx
```

---

### 4.2. Guide d'installation Windows (WAMP)

#### Prérequis

- Installer [WAMP Server](https://www.wampserver.com/)
- PHP 8.3
- MySQL
- Node.js et NPM

#### Étapes

1. Placer le projet dans le dossier `www/` de WAMP.

2. Copier `.env.example` en `.env` et configurer la connexion à MySQL.

3. Lancer `composer install` dans le terminal WAMP.

4. Générer la clé :
```bash
php artisan key:generate
```

5. Créer la base de données via phpMyAdmin.

6. Lancer les migrations :
```bash
php artisan migrate --seed
```

7. Installer les dépendances front-end :
```bash
npm install
npm run dev
```

8. Accéder au projet via `http://localhost/numeratheque/public`.

---

## 5. Déploiement en production

- Serveur Debian 11
- Nginx configuré pour Laravel
- SSL via Certbot Let's Encrypt
- Gestion des processus avec Supervisor (optionnel)
- Accès distant sécurisé uniquement via VPN WireGuard

---

## 6. Sécurité

- VPN WireGuard obligatoire pour l'accès SSH et administration.
- Authentification Laravel Breeze.
- Chiffrement des mots de passe (bcrypt).

---


## 7. Sauvegarde automatique

Script `backup_script.sh` :

```bash
#!/bin/bash
DATE=$(date +%F)
mysqldump -u utilisateur -p'motdepasse' numeratheque > /backup/numeratheque_$DATE.sql
tar -czvf /backup/numeratheque_laravel_$DATE.tar.gz /var/www/numeratheque
```

Ajout dans cron :
```bash
0 2 * * * /chemin/vers/backup_script.sh
```

---

## 8. Tests

Lancer les tests avec :
```bash
php artisan test
```

---

## 9. Documentation

Documentation technique générée avec **Doxygen** :
```bash
doxygen Doxyfile
```

Résultat dans `docs/`.

---

## 10. Licence

Projet sous licence **MIT**.

---

# 🏁 Fin du README
