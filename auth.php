<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();
$pdo = db();

header("Content-Type: application/json");

$action = $_POST["action"] ?? null;
$data = $_POST;

if ($action === "login") {
    $query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$data['username']]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(["success" => false, "message" => "Utilisateur introuvable."]);
        exit;
    }

    if (!password_verify($data['password'], $user["password"])) {
        echo json_encode(["success" => false, "message" => "Mot de passe incorrect."]);
        exit;
    }

    unset($user["password"]);
    $_SESSION["authenticated"] = $user;
    echo json_encode(["success" => true]);
    exit;
}

if ($action === "register") {
    if ($data['password'] !== $data['confirm']) {
        echo json_encode(["success" => false, "message" => "Mots de passe incompatibles."]);
        exit;
    }
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $create_query = $pdo->prepare("INSERT INTO users (email, fullname, username, password) VALUES (?, ?, ?, ?)");
    try {
        $create_query->execute([
            $data['email'],
            $data['fullname'],
            $data['username'],
            $password,
        ]);

        $get_query = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $get_query->execute([$data['email']]);
        $user = $get_query->fetch();

        unset($user["password"]);
        $_SESSION["authenticated"] = $user;
        echo json_encode(["success" => true]);
        exit;
    } catch (\Throwable $e) {
        $json = json_encode($e);
        $error = json_decode($json, true);
        $message = $error["errorInfo"][2];

        if (stripos($message, "unique_email") !== false)
            echo json_encode(["success" => false, "message" => "Email déjà utilisé."]);
        else if (stripos($message, "unique_username") !== false)
            echo json_encode(["success" => false, "message" => "Username déjà utilisé."]);
        else
            echo json_encode(["success" => false, "message" => $e->getMessage()]);

        exit;
    }
}
