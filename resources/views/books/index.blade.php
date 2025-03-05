<h1>Liste des livres</h1>

<a href="{{ route('books.create') }}">Ajouter un livre</a>

<ul>
@foreach($books as $book)
    <li>
        {{ $book->title }} par {{ $book->author }} ({{ $book->category->name }})
        <a href="{{ route('books.show', $book) }}">Voir</a>
        <a href="{{ route('books.edit', $book) }}">Modifier</a>
        <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Supprimer</button>
        </form>
    </li>
@endforeach
</ul>
