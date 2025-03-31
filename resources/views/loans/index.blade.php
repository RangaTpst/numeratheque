<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestion des emprunts') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-primary">Liste des emprunts</h1>
            <a href="{{ route('loans.create') }}" class="btn btn-primary">Ajouter un emprunt</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Livre</th>
                            <th>Emprunté par</th>
                            <th>Date d'emprunt</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $loan)
                            <tr>
                                <td>{{ $loan->book->title }}</td>
                                <td>{{ $loan->user->name }}</td>
                                <td>{{ $loan->loan_date ? $loan->loan_date->format('d/m/Y') : 'Non définie' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                    <a href="{{ route('loans.edit', $loan) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>

                                    {{-- Bouton retour si le livre n'a pas encore été rendu --}}
                                    @if(!$loan->returned)
                                        <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('Confirmer le retour de ce livre ?')">
                                                Marquer comme retourné
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet emprunt ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun emprunt enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Retour au tableau de bord</a>
        </div>
    </div>
</x-app-layout>
