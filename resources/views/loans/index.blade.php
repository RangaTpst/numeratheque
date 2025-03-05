<h1>Liste des emprunts</h1>

<a href="{{ route('loans.create') }}">Ajouter un emprunt</a>

<ul>
@foreach($loans as $loan)
    <li>
        Livre : {{ $loan->book->title }} | Emprunté par : {{ $loan->user->name }} | Date d'emprunt : {{ $loan->loan_date->format('d/m/Y') }}
        <a href="{{ route('loans.show', $loan) }}">Voir</a>
        <a href="{{ route('loans.edit', $loan) }}">Modifier</a>
        <form action="{{ route('loans.destroy', $loan) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>
    </li>
@endforeach
</ul>

<a href="{{ route('dashboard') }}">Retour au tableau de bord</a>
