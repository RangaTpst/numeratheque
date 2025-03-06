<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Numérateque - Tableau de bord</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('layouts.header')

    <main class="container py-5">
        <h1 class="mb-4 text-primary">Bienvenue dans votre espace personnel, {{ Auth::user()->name }} !</h1>

        {{-- Affichage des livres empruntés --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                Vos emprunts en cours
            </div>
            <div class="card-body">
                @if($loans->count() > 0)
                    <ul class="list-group">
                        @foreach($loans as $loan)
                            <li class="list-group-item">
                                <strong>{{ $loan->book->title }}</strong>
                                par {{ $loan->book->author }}
                                <br>
                                Emprunté le {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }},
                                retour prévu le {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : 'non défini' }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Vous n'avez aucun livre emprunté actuellement.</p>
                @endif
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
