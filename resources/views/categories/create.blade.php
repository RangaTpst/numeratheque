<h1>Ajouter une catégorie</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <label for="name">Nom de la catégorie :</label>
    <input type="text" name="name" required>

    <button type="submit">Enregistrer</button>
</form>

<a href="{{ route('categories.index') }}">Retour à la liste des catégories</a>
