<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier le livre') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h1 class="h4 mb-4 text-primary">Modifier le livre</h1>

                <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" name="title" id="title" class="form-control"
                               value="{{ old('title', $book->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Auteur</label>
                        <input type="text" name="author" id="author" class="form-control"
                               value="{{ old('author', $book->author) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Date de publication</label>
                        <input type="date" name="published_at" id="published_at" class="form-control"
                               value="{{ old('published_at', $book->published_at ? $book->published_at->format('Y-m-d') : '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Résumé</label>
                        <textarea name="summary" id="summary" class="form-control"
                                  placeholder="Entrez un résumé du livre..." rows="5">{{ old('summary', $book->summary) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($book->image)
                        <div class="mb-3">
                            <p class="fw-bold">Image actuelle :</p>
                            <img src="{{ asset('storage/' . $book->image) }}" alt="Image de {{ $book->title }}"
                                 class="img-fluid mb-3 rounded" style="max-width: 200px;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">Nouvelle image (optionnel)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('books.index') }}" class="btn btn-secondary">Retour à la liste</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
