<h1>{{ $book->title }}</h1>
<p>Auteur : {{ $book->author }}</p>
<p>Publié le : {{ $book->published_at }}</p>
<p>Catégorie : {{ $book->category->name }}</p>
