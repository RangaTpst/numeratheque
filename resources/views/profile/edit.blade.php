<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Numérateque - Mon profil</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('layouts.header')

    <main class="container py-5">
        <h1 class="mb-4 text-primary">Mon profil</h1>

        {{-- Formulaire de mise à jour des informations --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Modifier mes informations
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Formulaire de changement de mot de passe --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                Changer mon mot de passe
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Formulaire de suppression du compte --}}
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                Supprimer mon compte
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
