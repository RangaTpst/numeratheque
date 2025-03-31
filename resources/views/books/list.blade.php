<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catalogue des livres') }}
        </h2>
    </x-slot>

    <div class="container py-5">

        {{-- Formulaire de filtres --}}
        <form method="GET" action="{{ route('books.list') }}" class="row mb-4 align-items-end">
            {{-- Filtre par catégorie --}}
            <div class="col-md-4">
                <label for="category" class="form-label">Filtrer par catégorie :</label>
                <select name="category" id="category" class="form-select">
                    <option value="">-- Toutes les catégories --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Barre de recherche --}}
            <div class="col-md-4">
                <label for="search" class="form-label">Recherche :</label>
                <input type="text" name="search" id="search" class="form-control"
                       value="{{ request('search') }}" placeholder="Titre, auteur ou catégorie">
            </div>

            {{-- Boutons --}}
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('books.list') }}" class="btn btn-outline-secondary w-100">Réinitialiser</a>
            </div>
        </form>

        {{-- Grille des livres --}}
        <div class="row">
            @forelse($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text mb-4">
                                Auteur : {{ $book->author }}<br>
                                Publié le : {{ \Carbon\Carbon::parse($book->published_at)->format('d/m/Y') }}<br>
                                Catégorie : {{ $book->category->name ?? 'Non définie' }}<br>
                                Statut :
                                @if($book->isBorrowed())
                                    <span class="badge bg-danger">Emprunté</span>
                                @else
                                    <span class="badge bg-success">Disponible</span>
                                @endif
                            </p>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary mt-auto">Voir les détails</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-warning">
                        Aucun livre trouvé pour les critères sélectionnés.
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>
