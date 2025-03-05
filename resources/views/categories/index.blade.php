<h1>Liste des catégories</h1>

<a href="{{ route('categories.create') }}">Ajouter une catégorie</a>

<ul>
@foreach($categories as $category)
    <li>
        {{ $category->name }}
        <a href="{{ route('categories.show', $category) }}">Voir</a>
        <a href="{{ route('categories.edit', $category) }}">Modifier</a>
        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>
    </li>
@endforeach
</ul>

<a href="{{ route('dashboard') }}">Retour au tableau de bord</a>
