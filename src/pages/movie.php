<section id="movie-section" class="h-100 container">
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-4 text-center">
                <img id="movie-poster" class="img-fluid rounded shadow-sm" alt="Movie poster">
            </div>

            <div class="col-md-8">
                <h1 id="movie-title" class="fw-bold mb-2"></h1>

                <div class="text-muted mb-3">
                    <span id="movie-year"></span> •
                    <span id="movie-runtime"></span> •
                    <span id="movie-genres"></span>
                </div>

                <p id="movie-plot" class="truncate-4"></p>

                <div class="mt-3">
                    <p class="mb-1"><strong>Directeur:</strong>
                        <button id="movie-director" class="btn btn-link p-0"></button>
                    </p>

                    <p class="mb-1"><strong>Acteurs:</strong>
                        <span id="movie-actors"></span>
                    </p>
                </div>

                <div class="mt-4">
                    <button class="btn btn-secondary" onclick="history.back()">← Retour</button>
                    <button class="btn btn-primary">Ajouter au panier</button>
                </div>
            </div>
        </div>

        <hr>

        <div id="movie-overview"></div>

        <!-- OPTIONAL: Similar Movies -->
        <!-- <h3 class="fw-semibold mb-3">Similar Movies</h3>
        <div id="similar-movies" class="row g-4"> -->
            <!-- JS will inject cards here -->
        <!-- </div> -->

    </div>
</section>