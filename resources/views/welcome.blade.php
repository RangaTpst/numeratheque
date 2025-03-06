<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Numérateque - Accueil</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('layouts.header')

    <main class="container text-center py-5">
        <h2 class="mb-4 text-primary">Bienvenue sur Numérateque</h2>
        <p class="lead mb-5">Gérez vos livres, catégories et emprunts facilement depuis votre espace personnel.</p>

        @auth
            <p class="mb-4">Bonjour, {{ Auth::user()->name }} !</p>

            <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <a href="{{ route('books.list') }}" class="btn btn-outline-primary">Voir les Livres</a>
            </div>

        @else
            <p class="lead mb-4">Connectez-vous pour accéder à toutes les fonctionnalités :</p>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('login') }}" class="btn btn-outline-success">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary">Inscription</a>
            </div>
        @endauth
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
