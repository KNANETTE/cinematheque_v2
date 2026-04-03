<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
$pdo = db();

$token = $_ENV["API_TOKEN"];
$data = $_GET;

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ["Authorization: Bearer $token"],
]);

function getTrendingMovies($curl, $page)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/trending/movie/day?page=$page&language=fr-Fr");
    $response = curl_exec($curl);
    return $response;
}

function searchMovies($curl, $search, $page)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/search/movie?query=$search&page=$page&language=fr-Fr");
    $response = curl_exec($curl);
    return $response;
}

function getGenres($curl)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/genre/movie/list");
    $response = curl_exec($curl);
    return $response;
}

function getCredits($curl, $mid)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/movie/$mid/credits");
    $response = curl_exec($curl);
    return $response;
}

function getDirector($curl, $did)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/person/$did");
    $response = curl_exec($curl);
    return $response;
}

function getMovieCredits($curl, $did)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/person/$did/movie_credits?language=fr-Fr");
    $response = curl_exec($curl);
    return $response;
}

function getMovie($curl, $mid)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/movie/$mid?language=fr-Fr");
    $response = curl_exec($curl);
    return $response;
}

function getMoviesByGenre($curl, $gid)
{
    curl_setopt($curl, CURLOPT_URL, "https://api.themoviedb.org/3/discover/movie?with_genres=$gid&language=fr-Fr");
    $response = curl_exec($curl);
    return $response;
}

function addToCart($curl, $mid)
{
    $movie = getMovie($curl, str_replace(['[', ']'], '', $mid));
    if (!isset($_SESSION["cart"]))
        $_SESSION["cart"] = [$movie];
    else
        $_SESSION["cart"][] = $movie;

    return json_encode($_SESSION["cart"]);
}

function removeFromCart($index)
{
    if (isset($_SESSION["cart"][$index])) {
        unset($_SESSION["cart"][$index]);
        $_SESSION["cart"] = array_values($_SESSION["cart"]);
    }
    return json_encode($_SESSION["cart"]);
}

function getCart()
{
    if (!isset($_SESSION["cart"]))
        return json_encode([]);
    return json_encode($_SESSION["cart"]);
}

function buyMovie($pdo)
{
    $userId = $_SESSION["authenticated"]['id'];
    $movies = $_SESSION["cart"];
    foreach ($movies as $movie) {
        $movie = json_decode($movie, true);
        // var_dump($movie);
        $query = $pdo->prepare(
            "INSERT INTO purchases (user_id, movie_id, movie_name, movie_poster, movie_overview) VALUES( ?, ?, ?, ?, ?)"
        );
        $query->execute([$userId, $movie["id"], $movie["title"], $movie["poster_path"], $movie["overview"]]);
    }
    unset($_SESSION["cart"]);
}

function getPurchased($pdo)
{
    $query = $pdo->prepare("SELECT * FROM purchases WHERE user_id=?");
    $query->execute([$_SESSION["authenticated"]["id"]]);

    $history = $query->fetchAll();
    return $history;
}


if (!isset($data["q"])) exit;

header("Content-Type: application/json");
switch ($data["q"]) {
    case 'genres':
        echo getGenres($curl, $token);
        exit;
        break;

    case 'search':
        echo searchMovies($curl, $data["search"], $data["page"]);
        exit;
        break;

    case 'credits':
        echo getCredits($curl, $data["id"]);
        exit;
        break;

    case 'director':
        echo getDirector($curl, $data["id"]);
        exit;
        break;

    case 'movie_credits':
        echo getMovieCredits($curl, $data["id"]);
        exit;
        break;

    case 'movie':
        echo getMovie($curl, $data["id"]);
        exit;
        break;

    case 'movie_genre':
        echo getMoviesByGenre($curl, $data["id"]);
        exit;
        break;

    case 'cart':
        echo addToCart($curl, $data["id"]);
        exit;
        break;

    case 'get_cart':
        echo getCart();
        exit;
        break;

    case 'remove_cart':
        echo removeFromCart($data['index']);
        exit;
        break;

    case 'buy':
        echo buyMovie($pdo);
        exit;
        break;

    case 'history':
        echo getPurchased($pdo);
        exit;
        break;

    case 'trending':

    default:
        echo getTrendingMovies($curl, $data["page"]);
        exit;
        break;
}
