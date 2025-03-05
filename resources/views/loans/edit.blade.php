<h1>Modifier l'emprunt</h1>

<form action="{{ route('loans.update', $loan) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="user_id">Utilisateur :</label>
    <select name="user_id" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ $loan->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    <label for="book_id">Livre :</label>
    <select name="book_id" required>
        @foreach($books as $book)
            <option value="{{ $book->id }}" {{ $loan->book_id == $book->id ? 'selected' : '' }}>
                {{ $book->title }}
            </option>
        @endforeach
    </select>

    <label for="loan_date">Date d'emprunt :</label>
    <input type="date" name="loan_date" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" required>

    <label for="return_date">Date de retour :</label>
    <input type="date" name="return_date" value="{{ old('return_date', optional($loan->return_date)->format('Y-m-d')) }}">

    <button type="submit">Enregistrer les modifications</button>
</form>

<a href="{{ route('loans.index') }}">Retour à la liste des emprunts</a>
