<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter une catégorie') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <h1 class="h3 text-primary mb-4">Ajouter une catégorie</h1>

        <form action="{{ route('categories.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control"
                       placeholder="Nom de la catégorie" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour à la liste</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</x-app-layout>
