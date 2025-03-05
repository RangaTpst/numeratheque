<h1>Ajouter un livre</h1>

<form action="{{ route('books.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Titre">
    <input type="text" name="author" placeholder="Auteur">
    <input type="date" name="published_at">
    <select name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit">Enregistrer</button>
</form>
