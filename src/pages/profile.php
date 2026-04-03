<section id="profile-section" class="container-fluid">
    <div class="container py-5">
        <h2 class="mb-4"><?= $_SESSION["authenticated"]["fullname"] ?></h2>

        <div class="form-check form-switch mb-4">
            <input class="form-check-input" type="checkbox" id="editSwitch">
            <label class="form-check-label" for="editSwitch">Activer la modification</label>
        </div>

        <form id="profileForm">
            <div class="mb-3">
                <label class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" name="username" disabled value="<?= $_SESSION["authenticated"]["username"] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Prénom(s) et NOM</label>
                <input type="text" class="form-control" name="fullname" disabled value="<?= $_SESSION["authenticated"]["fullname"] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Adresse mail</label>
                <input type="email" class="form-control" name="email" disabled value="<?= $_SESSION["authenticated"]["email"] ?>">
            </div>

            <button type="submit" class="btn btn-primary" disabled id="saveBtn">
                Enregistrer
            </button>
        </form>
    </div>
</section>

<hr />

<section id="purchased-section" class="container-fluid">
    <h3>Historique d'achats</h3>
    <div id="purchased-history" class="container-fluid"></div>
</section>

<script>
    const switchBtn = document.getElementById("editSwitch");
    const form = document.getElementById("profileForm");
    const saveBtn = document.getElementById("saveBtn");

    switchBtn.addEventListener("change", () => {
        const enabled = switchBtn.checked;

        // Enable/disable all inputs
        form.querySelectorAll("input").forEach(input => {
            input.disabled = !enabled;
        });

        // Enable/disable save button
        saveBtn.disabled = !enabled;
    });

    // async function getHistory() {
    //     const res = await fetch("/movies.php?history")
    //     const data = await res.json()

    //     console.log(data)
    // }
    fetch("/movies.php?history")
        .then(res => {
            console.table(res)
            return res.text()
        })
        .then(data => console.log(data))
</script>