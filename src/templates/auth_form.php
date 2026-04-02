<?php

// $pdo = db();

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
//     $data = $_POST;

//     $get_user = $pdo->prepare("SELECT * FROM users WHERE username = ?");
//     $get_user->execute([$data['username']]);
//     $get_user = $get_user->fetch();

//     if (!$get_user) $login_error = "Pas de compte lié à ce nom d'utilisateur.";
//     else if (!password_verify($data['password'], $get_user['password'])) $login_error = "Mot de passe incorrecte.";
//     else {
//         $_SESSION["authenticated"] = json_encode($get_user);
//         header("Location :/");
//         exit;
//     }
// }

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
//     $data = $_POST;

//     if ($data['password'] !== $data['confirm']) {
//         $register_error = "Les mots de passe ne correspondent pas.";
//     } else {
//         $password = password_hash($data['password'], PASSWORD_DEFAULT);
//         $create_user = $pdo->prepare("INSERT INTO users (email, fullname, username, password) VALUES (?, ?, ?, ?)");
//         try {
//             $create_user->execute([
//                 $data['email'],
//                 $data['fullname'],
//                 $data['username'],
//                 $password,
//             ]);

//             $get_user = $pdo->prepare("SELECT fullname, username, email, created_at, updated_at FROM users WHERE email = ?");
//             $get_user->execute([$data['email']]);
//             $get_user = $get_user->fetch();

//             $_SESSION["authenticated"] = json_encode($get_user);
//             header("Location :/");
//             exit;
//         } catch (\Throwable $e) {
//             $json = json_encode($e);
//             $error = json_decode($json, true);
//             $message = $error["errorInfo"][2];

//             if (stripos($message, "unique_email") !== false) {
//                 $register_error = "Cet email est déjà utilisé!";
//             }

//             if (stripos($message, "unique_username") !== false) {
//                 $register_error = "Ce nom d'utilisateur est déjà pris!";
//             }
//         }
//     }
// }
?>

<section id="auth-section" class="h-100 container-fluid">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div id="auth-container" class="card shadow p-4">
            <div id="loginForm">
                <h3 class="text-center mb-3">CONNEXION</h3>

                <div id="auth-error" class="d-none"></div>

                <form id="formLogin">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label for="username"><i class="fa-light fa-user"></i>Nom d'utilisateur</label>
                        <input name="username" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password"><i class="fa-light fa-lock"></i>Mot de passe</label>
                        <input name="password" type="password" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">SE CONNECTER</button>
                </form>

                <p class="text-center mt-3">
                    Pas encore de compte?
                    <button class="btn btn-link p-0" onclick="showRegister()">Inscrivez vous!</button>
                </p>
            </div>

            <div id="registerForm" class="d-none">
                <h3 class="text-center mb-3">INSCRIPTION</h3>

                <div id="auth-error" class="d-none"></div>

                <form id="formRegister">
                    <input type="hidden" name="action" value="register">
                    <div class="mb-3">
                        <label for="email">Adresse mail</label>
                        <input id="email" name="email" type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="fullname">Prénom(s) et NOM</label>
                        <input id="fullname" name="fullname" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="username">Nom d'utilisateur</label>
                        <input id="username" name="username" type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input id="password" name="password" type="password" class="form-control" oninput="validatePassword()" required>
                        <ul id="passwordRules">
                            <li id="rule-length">* 8+ caractères</li>
                            <li id="rule-lower">* 1+ minuscule</li>
                            <li id="rule-upper">* 1+ majuscule</li>
                            <li id="rule-number">* 1+ chiffre</li>
                            <li id="rule-symbol">* 1+ caractère spécial</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label>Confirmer le mot de passe</label>
                        <input id="confirm" name="confirm" type="password" class="form-control" oninput="validatePassword()" required>
                    </div>
                    <button class="btn btn-success w-100">S'INSCRIRE</button>
                </form>

                <p class="text-center mt-3">
                    Déjà inscrit?
                    <button class="btn btn-link p-0" onclick="showLogin()">Connectez vous!</button>
                </p>
            </div>
        </div>
    </div>
</section>