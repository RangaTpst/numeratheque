<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Numérateque') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <!-- HEADER GLOBAL -->
    <header class="bg-dark text-white p-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h4 m-0"><a href="{{ route('welcome') }}" class="text-white text-decoration-none">Numérateque</a></h1>
            <nav>
                <a href="{{ route('dashboard') }}" class="text-white me-3">Tableau de bord</a>
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-warning me-3">Administration</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="text-white me-3">Profil</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-white me-3">Connexion</a>
                    <a href="{{ route('register') }}" class="text-white">Inscription</a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Page Content -->
    <main class="container py-5">
        {{ $slot }}
    </main>

    <!-- FOOTER GLOBAL -->
    <footer class="bg-dark text-white text-center p-3 mt-4">
        © {{ date('Y') }} Numérateque - Tous droits réservés.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
