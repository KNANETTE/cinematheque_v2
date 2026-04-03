<section class="container h-100" id="director-section">
    <div class="container">

        <div class="row mb-4">
            <div class="col-md-3">
                <button class="btn btn-link" onclick="history.back()">← Retour</button>
            </div>
            <div class="col-md-9">
                <h1 id="director-name" class="fw-bold mb-3"></h1>

                <p id="director-bio" class="truncate-3 text-muted"></p>

                <div class="mt-3">
                    <p class="mb-1"><strong>Né(e) le:</strong> <span id="director-birthday"></span></p>
                    <p class="mb-1"><strong>Décédé(e) le:</strong> <span id="director-deathday"></span></p>
                </div>
            </div>
        </div>

        <hr>

        <h2 class="fw-semibold mb-3">Films</h2>

        <div id="movies-grid" class="row g-4">
        </div>

    </div>
</section>