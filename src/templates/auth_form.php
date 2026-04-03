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