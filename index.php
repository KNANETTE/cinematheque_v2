<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($path === '') $path = 'home';
$pageFile = __DIR__ . "/src/pages/{$path}.php";

require __DIR__ . '/src/templates/header.php';

if (!isset($_SESSION["authenticated"]))
    require __DIR__ . '/src/templates/auth_form.php';
else {
    require __DIR__ . '/src/templates/navbar.php';
    if (file_exists($pageFile)) {
        require $pageFile;
    } else {
        http_response_code(404);
        echo "<h1>404 - Page not found</h1>";
    }
}

require __DIR__ . '/src/templates/footer.php';
