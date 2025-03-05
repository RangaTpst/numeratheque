<h1>Ajouter un emprunt</h1>

<form action="{{ route('loans.store') }}" method="POST">
    @csrf

    <label for="user_id">Utilisateur :</label>
    <select name="user_id" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <label for="book_id">Livre :</label>
    <select name="book_id" required>
        @foreach($books as $book)
            <option value="{{ $book->id }}">{{ $book->title }}</option>
        @endforeach
    </select>

    <label for="loan_date">Date d'emprunt :</label>
    <input type="date" name="loan_date" required>

    <label for="return_date">Date de retour (optionnelle) :</label>
    <input type="date" name="return_date">

    <button type="submit">Enregistrer</button>
</form>

<a href="{{ route('loans.index') }}">Retour à la liste des emprunts</a>
