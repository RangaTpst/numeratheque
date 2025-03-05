<h1>Détails de l'emprunt</h1>

<p>Utilisateur : {{ $loan->user->name }}</p>
<p>Livre : {{ $loan->book->title }}</p>
<p>Date d'emprunt : {{ $loan->loan_date->format('d/m/Y') }}</p>
<p>Date de retour : {{ $loan->return_date ? $loan->return_date->format('d/m/Y') : 'Non renseignée' }}</p>

<a href="{{ route('loans.index') }}">Retour à la liste des emprunts</a>
<a href="{{ route('loans.edit', $loan) }}">Modifier</a>
<form action="{{ route('loans.destroy', $loan) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit">Supprimer</button>
</form>
