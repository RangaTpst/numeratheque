<form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?');">
    @csrf
    @method('delete')

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input id="password" name="password" type="password" class="form-control" required autocomplete="current-password">
    </div>

    <button class="btn btn-danger" type="submit">Supprimer mon compte</button>
</form>
