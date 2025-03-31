<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Numérateque - Accueil</title>

    @vite('resources/css/app.css')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            background: url('{{ asset('images/bibliotheque.jpg') }}') center center / cover no-repeat;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 0 0 8px rgba(0,0,0,0.7);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    @include('layouts.header')

    <main class="flex-grow-1">

        {{-- HERO SECTION --}}
        <section class="hero text-center px-3">
            <div>
                <h1 class="display-4 fw-bold">Bienvenue sur Numérateque</h1>
                <p class="lead">Votre bibliothèque moderne et intuitive</p>

                <div class="mt-4">
                    <a href="{{ route('books.list') }}" class="btn btn-primary me-2">Voir les Livres</a>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Connexion</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light">Espace personnel</a>
                    @endguest
                </div>
            </div>
        </section>

        {{-- SECTION PRÉSENTATION --}}
        <section class="container py-5 text-center">
            <h2 class="mb-4 text-primary">Pourquoi utiliser Numérateque ?</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">📚 Livres</h5>
                            <p class="card-text">Consultez les livres disponibles, les auteurs, les dates et bien plus encore.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">🗂️ Catégories</h5>
                            <p class="card-text">Parcourez les livres par catégorie pour mieux vous y retrouver.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">📖 Emprunts</h5>
                            <p class="card-text">Visualisez vos emprunts en cours et votre historique.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION LIVRES ALÉATOIRES --}}
        @if($category && $books->count())
            <section class="container py-5 text-center">
                <h2 class="mb-4 text-primary">Découvrez des livres dans la catégorie <strong>{{ $category->name }}</strong></h2>
                <div class="row">
                    @foreach($books as $book)
                        <div class="col-md-3 mb-4">
                            <div class="card shadow-sm h-100">
                                @if($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" alt="Image de {{ $book->title }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                        Pas d’image
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $book->title }}</h5>
                                    <p class="card-text mb-3">
                                        Auteur : {{ $book->author }}<br>
                                        Publié le : {{ \Carbon\Carbon::parse($book->published_at)->format('d/m/Y') }}
                                    </p>
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary mt-auto">Voir le livre</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
