<h1>Modifier le livre</h1>

<form action="{{ route('books.update', $book) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="title">Titre :</label>
    <input type="text" name="title" value="{{ old('title', $book->title) }}" required>

    <label for="author">Auteur :</label>
    <input type="text" name="author" value="{{ old('author', $book->author) }}" required>

    <label for="published_at">Date de publication :</label>
    <input type="date" name="published_at" value="{{ old('published_at', $book->published_at->format('Y-m-d')) }}">

    <label for="category_id">Catégorie :</label>
    <select name="category_id" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="{{ route('books.index') }}">Retour à la liste des livres</a>
