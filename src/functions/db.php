<?php

function db()
{
    static $pdo = null;
    
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_NAME'];
    $dbuser = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];

    if ($pdo === null) {
        $pdo = new \PDO(
            "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
            $dbuser,
            $password
        );
    }

    return $pdo;
}
