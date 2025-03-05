<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numérateque - Accueil</title>
    <!-- Lien CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center py-5">

    <div class="container">
        <h1 class="mb-4 text-primary">Bienvenue sur Numérateque</h1>
        <p class="mb-5">Gérez vos livres, catégories et emprunts facilement depuis votre espace personnel.</p>

        @auth
            <p class="lead mb-4">Bonjour, {{ Auth::user()->name }} !</p>

            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('books.index') }}" class="btn btn-primary">Voir les livres</a>
                <a href="{{ route('categories.index') }}" class="btn btn-primary">Voir les catégories</a>
                <a href="{{ route('loans.index') }}" class="btn btn-primary">Voir les emprunts</a>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">Accès Administration</a>
                @endif

                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Mon tableau de bord</a>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Mon profil</a>
            </div>

        @else
            <p class="lead mb-4">Connectez-vous pour accéder à toutes les fonctionnalités :</p>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-success">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-outline-success">Inscription</a>
            </div>
        @endauth
    </div>

    <!-- Script Bootstrap (optionnel) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
