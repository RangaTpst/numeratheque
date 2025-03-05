<h1>Modifier la catégorie</h1>

<form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="name">Nom de la catégorie :</label>
    <input type="text" name="name" value="{{ old('name', $category->name) }}" required>

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="{{ route('categories.index') }}">Retour à la liste des catégories</a>
