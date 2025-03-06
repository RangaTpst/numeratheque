<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="current_password" class="form-label">Mot de passe actuel</label>
        <input id="current_password" name="current_password" type="password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Nouveau mot de passe</label>
        <input id="password" name="password" type="password" class="form-control" required autocomplete="new-password">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required autocomplete="new-password">
    </div>

    <button class="btn btn-primary" type="submit">Mettre à jour le mot de passe</button>
</form>
