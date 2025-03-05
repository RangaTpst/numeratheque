<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Espace Administration - Numérateque</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('layouts.header')

    <main class="container text-center py-5">
        <h1 class="mb-4 text-primary">Espace Administration</h1>
        <p class="lead mb-5">Gérez les différentes ressources du site :</p>

        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-lg">Gestion des Livres</a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-lg">Gestion des Catégories</a>
            <a href="{{ route('loans.index') }}" class="btn btn-outline-success btn-lg">Gestion des Emprunts</a>
        </div>

        <div class="mt-5">
            <a href="{{ route('welcome') }}" class="btn btn-dark">Retour à l'accueil</a>
        </div>
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
