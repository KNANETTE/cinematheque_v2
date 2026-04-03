async function getGenres() {
    const resp = await fetch("/movies.php?q=genres")
    const data = await resp.json()

    return data
}

async function getTrendingMovies(page = 1) {
    const res = await fetch(`/movies.php?q=trending&page=${page}`)
    const data = await res.json()

    return data
}

async function searchMovies(search, page = 1) {
    const res = await fetch(`/movies.php?q=search&search=${search}&page=${page}`)
    const data = await res.json()

    return data
}

async function getMovie(movieId) {
    const res = await fetch(`/movies.php?q=movie&id=${movieId}`)
    const data = await res.json()

    return data
}

async function directorRedirect(btn) {
    location.assign(`/director?${btn.value}`)
}

async function movieRedirect(btn) {
    location.assign(`/movie?${btn.value}`)
}

async function displayMovie(movie) {
    const poster = document.getElementById("movie-poster")
    const res = await fetch(`/movies.php?q=credits&id=${movie.id}`)
    const data = await res.json()
    let actors = data.cast
    actors = actors.map(actor => actor.name)
    const director = data.crew.find(person => person.job === "Director")
    poster.src = `https://image.tmdb.org/t/p/w400/${movie.poster_path}`
    poster.alt = movie.title
    document.getElementById("movie-title").textContent = movie.title
    document.getElementById("movie-year").textContent = movie.release_date
    document.getElementById("movie-runtime").textContent = `${movie.runtime} min`
    genres = movie.genres.map(genre => genre.name).join(", ")
    document.getElementById("movie-genres").textContent = genres
    const director_button = document.getElementById("movie-director")
    if (director) {
        director_button.textContent = director.name
        director_button.addEventListener("click", () => location.assign(`/director?${director.id}`))
    }
    document.getElementById("movie-actors").textContent = actors.join(", ")
    document.getElementById("movie-overview").textContent = movie.overview
}

async function addToCart(btn) {
    await fetch(`/movies.php?q=cart&id=[${btn.value}]`)
}

function renderCartMovie(movie, index) {
    movie = JSON.parse(movie)
    const movie_item = document.createElement('div')
    const poster = `https://image.tmdb.org/t/p/w200/${movie.poster_path}`
    movie_item.class = "movie-item"
    movie_item.innerHTML = `
            <div id="movie-row-${index}" class="movie-item">
                
                <img src="${poster}" class="movie-poster" alt="${movie.title}">
                
                <div class="movie-info">
                    <div class="movie-title">${movie.title}</div>
                    <div class="movie-plot truncate-2">${movie.overview}</div>
                </div>

                <div class="movie-actions">
                    <div class="movie-price"> 9.99 €</div>
                    <button class="btn btn-danger btn-sm" onclick='removeFromCart(this)' value="${index}">
                        Retirer du panier
                    </button>
                </div>

            </div>
        `
    return movie_item
}

async function showTotal() {
    const cart = await getCart()
    const total = parseInt(cart.length) * 9.99

    document.getElementById('total-price').textContent = `Total du panier: ${total} €`
}

async function removeFromCart(btn) {
    const res = await fetch(`movies.php?q=remove_cart&index=${btn.value}`)
    const data = await res.json()
    const total = parseInt(data.length) * 9.99

    document.getElementById(`movie-row-${btn.value}`).remove()
    document.getElementById('total-price').textContent = `Total du panier: ${total} €`
}

function renderOneMovie(row, director, actors) {
    const movie_item = document.createElement('div')
    const poster = `https://image.tmdb.org/t/p/w200/${row.poster_path}`
    movie_item.class = "movie-item"
    movie_item.innerHTML = `
            <div class="movie-item">
                
                <img src="${poster}" class="movie-poster" alt="${row.title}">
                
                <div class="movie-info">
                    <div class="movie-title">${row.title}</div>
                    <div class="movie-plot truncate-2">${row.overview}</div>

                    <div class="movie-meta mt-2">
                        <button class='truncate-1 btn btn-link' onclick='directorRedirect(this)' value='${director.id}'>
                        <strong>Directeur:</strong> ${director ? director.name : " - "}
                        </button>
                        <div class='truncate-1'><strong>Acteurs:</strong> ${actors.join(", ")}</div>
                    </div>
                </div>

                <div class="movie-actions">
                    <div class="movie-price"> 9.99 €</div>
                    <button class="btn btn-link btn-sm" onclick='movieRedirect(this)' value="${row.id}">
                        Voir +
                    </button>
                    <button class="btn btn-primary btn-sm" onclick='addToCart(this)' value="${row.id}">
                        Ajouter au panier
                    </button>
                </div>

            </div>
        `
    return movie_item
}

function renderMovies(list) {
    let container = document.getElementById("movies-list")
    if (!container) container = document.getElementById("movies-grid")
    container.innerHTML = ""

    list.forEach(async movie => {
        const res = await fetch(`/movies.php?q=credits&id=${movie.id}`)
        const data = await res.json()
        const actors = data.cast
        const director = data.crew.find(person => person.job === "Director")
        container.appendChild(renderOneMovie(movie, director, actors.map(actor => actor.name)))
    })
}

function displayDirector(director) {
    document.getElementById("director-name").textContent = director.name
    document.getElementById("director-bio").textContent = director.biography
    document.getElementById("director-birthday").textContent = director.birthday
    document.getElementById("director-deathday").textContent = director.deathday ?? "-"
}

function debounce(fn, delay = 300) {
    let timeout
    return (...args) => {
        clearTimeout(timeout)
        timeout = setTimeout(() => fn(...args), delay)
    };
}

async function getCart() {
    const res = await fetch(`movies.php?q=get_cart`)
    const data = await res.json()

    return data
}

async function getMovieCredits(directorId) {
    const res = await fetch(`/movies.php?q=movie_credits&id=${directorId}`)
    const data = await res.json()

    return data
}

async function getDirector(directorId) {
    const res = await fetch(`/movies.php?q=director&id=${directorId}`)
    const data = await res.json()

    return data
}

async function getMoviesByGenre(genreId) {
    const res = await fetch(`movies.php?q=movie_genre&id=${genreId}`)
    const data = await res.json()

    return data
}

async function buy() {
    const res = await fetch(`/movies.php?q=buy`)
    const data = await res.text()

    document.getElementById("cart-movies").innerHTML = ""
    document.getElementById("total-price").innerHTML = "Total du panier: 0 €"
}

getGenres()
    .then(genres => {
        const genreMenu = document.getElementById("genre-menu")
        genres.genres.map(genre => {
            const genreEl = document.createElement("li")
            genreEl.innerHTML = `<a class="dropdown-item" href="/genre?${genre.id}">${genre.name}</a>`
            genreMenu.appendChild(genreEl)
        })
    })

if (window.location.pathname === "/")
    getTrendingMovies()
        .then(movies => {
            renderMovies(movies.results)
        })
else if (window.location.pathname.includes("director")) {
    const directorId = location.search.replace("?", "")
    getDirector(directorId)
        .then(director => displayDirector(director))
    getMovieCredits(directorId)
        .then(movies => renderMovies(movies.crew))
} else if (window.location.pathname.includes("movie")) {
    const movieId = location.search.replace("?", "")
    getMovie(movieId)
        .then(movie => displayMovie(movie))
} else if (window.location.pathname.includes("genre")) {
    const genreId = location.search.replace("?", "")
    getMoviesByGenre(genreId)
        .then(movies => renderMovies(movies.results))
} else if (window.location.pathname.includes("cart"))
    getCart()
        .then(movies => {
            movies.map((movie, index) => {
                document.getElementById("cart-movies").appendChild(renderCartMovie(movie, index))
            })
            showTotal()
        })

document.getElementById("search").addEventListener("input", debounce(async (e) => {
    const title = e.target.value.trim()
    if (title.length < 2) return
    const result = await searchMovies(title)
    renderMovies(result.results)
}, 400));