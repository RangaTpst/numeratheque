<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catalogue des livres') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="row">
            @foreach($books as $book)
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
            @endforeach
        </div>
    </div>
</x-app-layout>
