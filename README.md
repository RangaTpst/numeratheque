
# Projet Numérathèque

## Description

Le projet **Numérathèque** est une application de gestion de bibliothèque en ligne permettant aux utilisateurs de consulter, emprunter et gérer des livres. L'application a été développée avec Laravel 11 et utilise une base de données MySQL pour stocker les informations liées aux livres, utilisateurs et emprunts.

## Fonctionnalités

- Consultation des livres disponibles avec leurs détails (titre, auteur, date de publication, catégorie).
- Emprunt de livres avec possibilité de définir une date de retour.
- Gestion des livres, des catégories et des emprunts pour les administrateurs.
- Gestion des utilisateurs et de leurs droits d'accès.
- Gestion des images de couverture pour chaque livre.
- Interface simple et intuitive pour une navigation fluide.

## Installation

### Prérequis

- PHP >= 8.3
- Composer
- MySQL
- Nginx ou Apache
- Node.js (pour la gestion des assets via Vite)

### Étapes d'installation

1. Clonez le projet depuis GitHub :
    ```bash
    git clone https://github.com/votre-username/numeratheque.git
    cd numeratheque
    ```

2. Installez les dépendances PHP avec Composer :
    ```bash
    composer install
    ```

3. Copiez le fichier `.env.example` et renommez-le en `.env` :
    ```bash
    cp .env.example .env
    ```

4. Configurez votre base de données dans le fichier `.env` :
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nom_de_la_base
    DB_USERNAME=utilisateur
    DB_PASSWORD=mot_de_passe
    ```

5. Générez la clé d'application Laravel :
    ```bash
    php artisan key:generate
    ```

6. Exécutez les migrations pour créer les tables dans la base de données :
    ```bash
    php artisan migrate
    ```

7. Si vous souhaitez charger des données de test, vous pouvez utiliser les seeder :
    ```bash
    php artisan db:seed
    ```

8. Pour les assets (CSS, JS), vous devez compiler les ressources avec Vite :
    ```bash
    npm install
    npm run dev
    ```

9. Démarrez le serveur :
    ```bash
    php artisan serve
    ```

Le projet devrait maintenant être accessible via `http://127.0.0.1:8000` ou `http://votre-ip:8000`.

## Structure du projet

- **app/** : Contient la logique métier de l'application (contrôleurs, modèles, etc.)
- **resources/** : Contient les vues (Blade), les fichiers CSS/JS.
- **routes/** : Contient les fichiers de routes de l'application.
- **storage/** : Contient les fichiers générés ou téléchargés, y compris les images des livres.
- **tests/** : Contient les tests unitaires et fonctionnels.

## Tests

Pour exécuter les tests unitaires, utilisez la commande suivante :
```bash
php artisan test
```

## Documentation

Le projet utilise **Doxygen** pour générer la documentation technique. Vous pouvez lancer la génération avec :
```bash
doxygen Doxyfile
```

La documentation sera générée dans le dossier `docs/`.

## Licence

Ce projet est sous licence **MIT**. Voir le fichier [LICENSE](LICENSE) pour plus de détails.
