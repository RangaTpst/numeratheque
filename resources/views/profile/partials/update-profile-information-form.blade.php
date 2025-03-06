<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
    </div>

    <button class="btn btn-primary" type="submit">Enregistrer les modifications</button>
</form>
