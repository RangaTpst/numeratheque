<h1>Détails de la catégorie</h1>

<p>Nom : {{ $category->name }}</p>

<a href="{{ route('categories.index') }}">Retour à la liste des catégories</a>
<a href="{{ route('categories.edit', $category) }}">Modifier</a>
<form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit">Supprimer</button>
</form>
