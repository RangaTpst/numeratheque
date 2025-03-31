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
<body class="bg-light d-flex flex-column min-vh-100">

    @include('layouts.header')

    <main class="container py-5 flex-grow-1">
        <h1 class="mb-4 text-primary">Bienvenue dans votre espace personnel, {{ Auth::user()->name }} !</h1>

        {{-- STATS --}}
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total de livres</h6>
                        <h3>{{ $totalBooks }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Disponibles</h6>
                        <h3>{{ $availableBooks }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Empruntés</h6>
                        <h3>{{ $borrowedBooks }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Catégorie populaire</h6>
                        <h5>{{ $mostUsedCategory->name ?? 'Aucune' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- LIVRES EMPRUNTÉS EN COURS --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Vos emprunts en cours
            </div>
            <div class="card-body">
                @if($loans->count() > 0)
                    <ul class="list-group">
                        @foreach($loans as $loan)
                            <li class="list-group-item">
                                <strong>{{ $loan->book->title }}</strong>
                                par {{ $loan->book->author }}<br>
                                Emprunté le {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }},
                                retour prévu le {{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : 'non défini' }}

                                @if($loan->return_date && \Carbon\Carbon::parse($loan->return_date)->isPast())
                                    <div class="alert alert-warning mt-3 mb-0 py-2 px-3" role="alert">
                                        ⏰ Ce livre aurait dû être retourné.<br>
                                        Merci de le rapporter rapidement.<br>
                                        Trop de retards pourraient entraîner la suspension ou la suppression de votre compte.<br>
                                        <small>Si vous pensez que c'est une erreur, veuillez faire un ticket sur GLPI avec votre compte. Le lien est disponible en bas de page.</small>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Vous n'avez aucun livre emprunté actuellement.</p>
                @endif
            </div>
        </div>

        {{-- EMPRUNTS TERMINÉS --}}
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                Derniers emprunts terminés
            </div>
            <div class="card-body">
                @if($recentReturns->count() > 0)
                    <ul class="list-group">
                        @foreach($recentReturns as $loan)
                            <li class="list-group-item">
                                <strong>{{ $loan->book->title }}</strong>
                                retourné le {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Aucun retour récent.</p>
                @endif
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
