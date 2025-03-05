<header class="bg-dark text-white py-3 mb-5">
    <div class="container d-flex justify-content-between align-items-center">
        <h1 class="h4 m-0">Numérateque</h1>
        <nav>
            <a href="{{ route('welcome') }}" class="text-white me-3">Accueil</a>
            <a href="{{ route('dashboard') }}" class="text-white me-3">Tableau de bord</a>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-white me-3">Administration</a>
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
