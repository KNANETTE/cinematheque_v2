const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/;

function showRegister() {
    document.getElementById("loginForm").classList.add("d-none")
    document.getElementById("registerForm").classList.remove("d-none")
}

function showLogin() {
    document.getElementById("registerForm").classList.add("d-none")
    document.getElementById("loginForm").classList.remove("d-none")
}

function isValidPassword(password) {
    return passwordRegex.test(password)
}

function validatePassword() {
    const passwordInput = document.getElementById("password")
    const confirmInput = document.getElementById("confirm")
    if (!passwordInput) return
    if (!confirmInput) return

    const value = passwordInput.value
    const confirmed = confirmInput.value

    validateRule("rule-length", value.length >= 8)
    validateRule("rule-lower", /[a-z]/.test(value))
    validateRule("rule-upper", /[A-Z]/.test(value))
    validateRule("rule-number", /\d/.test(value))
    validateRule("rule-symbol", /[^A-Za-z0-9]/.test(value))

    if (value !== confirmed)
        confirmInput.setAttribute("class", "form-control border-danger-subtle")
    else
        confirmInput.setAttribute("class", "form-control")
}

function validateRule(id, isValid) {
    const el = document.getElementById(id);
    if (!el) return;

    el.classList.toggle("valid", isValid);
    el.classList.toggle("invalid", !isValid);
}

const loginEl = document.getElementById("formLogin")
if (loginEl) loginEl.addEventListener("submit", e => handleSubmit(e))

const registerEl = document.getElementById("formRegister")
if (registerEl) registerEl.addEventListener("submit", e => handleSubmit(e))

const logoutEl = document.getElementById("logout")
if (logoutEl) logoutEl.addEventListener("click", () => logout())

async function handleSubmit(e) {
    e.preventDefault()

    const formData = new FormData(e.target)
    if (!isValidPassword(formData.get("password"))) {
        document.getElementById("auth-error").textContent = "Mot de passe trop faible."
        document.getElementById("auth-error").setAttribute("class", "alert alert-danger")
        return
    }
    const res = await fetch("/auth.php", {
        method: "POST",
        body: formData
    })
    console.table(res)
    const data = await res.json()
    console.log(data)
    if (!data.success) {
        document.getElementById("auth-error").textContent = data.message
        document.getElementById("auth-error").setAttribute("class", "alert alert-danger")
        return
    }

    location.reload()
}

async function logout() {
    await fetch("/logout.php")
    location.assign("/")
}