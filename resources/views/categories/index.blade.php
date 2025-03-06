<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des catégories') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 text-primary">Liste des catégories</h1>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Ajouter une catégorie</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Retour au tableau de bord</a>
        </div>
    </div>
</x-app-layout>
