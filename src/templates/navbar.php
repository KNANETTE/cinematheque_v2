<nav class="navbar navbar-expand-lg bg-body-tertiary position-fixed top-0 start-0 end-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">CINEMATHEQUE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav w-75">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Genres
                </a>
                <ul class="dropdown-menu" id="genre-menu">
                </ul>
                <a class="nav-link mx-3" href="/profile">Profil</a>
                <a class="nav-link mx-3" href="/cart">Panier</a>
                <button class="nav-link mx-3" id="logout">Deconnexion</button>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" />
            </form>
        </div>
    </div>
</nav>