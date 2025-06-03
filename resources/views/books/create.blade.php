<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un livre') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="card shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-body">
                <h1 class="h4 mb-4 text-primary">Ajouter un livre</h1>

                <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" name="title" id="title" class="form-control"
                               placeholder="Titre du livre" required>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label">Auteur</label>
                        <input type="text" name="author" id="author" class="form-control"
                               placeholder="Nom de l'auteur" required>
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Date de publication</label>
                        <input type="date" name="published_at" id="published_at" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="summary" class="form-label">Résumé</label>
                        <textarea name="summary" id="summary" class="form-control"
                                  placeholder="Entrez un résumé du livre..." rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image du livre</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
