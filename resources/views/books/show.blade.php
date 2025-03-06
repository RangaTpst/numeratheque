<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détail du livre') }}
        </h2>
    </x-slot>

    <div class="container py-5">

        {{-- Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Carte principale : Infos et image --}}
        <div class="card mx-auto shadow-sm mb-4" style="max-width: 900px;">
            <div class="row g-0">

                {{-- Image à gauche --}}
                @if($book->image)
                    <div class="col-md-5">
                        <img src="{{ asset('storage/' . $book->image) }}" 
                             alt="Image de {{ $book->title }}" 
                             class="img-fluid h-100 rounded-start" 
                             style="object-fit: cover; width: 100%; min-height: 100%;">
                    </div>
                @endif

                {{-- Contenu texte à droite --}}
                <div class="col-md-7">
                    <div class="card-body d-flex flex-column h-100">
                        <h3 class="card-title">{{ $book->title }}</h3>
                        <p class="card-text">
                            <strong>Auteur :</strong> {{ $book->author }}<br>
                            <strong>Publié le :</strong> {{ \Carbon\Carbon::parse($book->published_at)->format('d/m/Y') }}<br>
                            <strong>Catégorie :</strong> {{ $book->category->name ?? 'Non définie' }}
                        </p>

                        {{-- Statut --}}
                        @if(!$book->isBorrowed())
                            <span class="badge bg-success mb-3">Disponible</span>

                            @auth
                                <form action="{{ route('books.borrow', $book) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="return_date" class="form-label">Date de retour souhaitée (optionnelle) :</label>
                                        <input type="date"
                                               name="return_date"
                                               id="return_date"
                                               class="form-control"
                                               min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}"
                                               max="{{ \Carbon\Carbon::today()->addMonth()->format('Y-m-d') }}">
                                        <small class="form-text text-muted">
                                            Si laissé vide, retour prévu dans 2 semaines. Max : {{ \Carbon\Carbon::today()->addMonth()->format('d/m/Y') }}.
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Emprunter ce livre</button>
                                </form>
                            @else
                                <p class="mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Connectez-vous pour emprunter</a>
                                </p>
                            @endauth

                        @else
                            <span class="badge bg-danger mb-3">Déjà emprunté</span>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('books.list') }}" class="btn btn-secondary w-100">Retour au catalogue</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Carte séparée pour le résumé --}}
        @if($book->summary)
            <div class="card mx-auto shadow-sm" style="max-width: 900px;">
                <div class="card-body">
                    <h4 class="card-title">Résumé</h4>
                    <p class="card-text">{{ $book->summary }}</p>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
