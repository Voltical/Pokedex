document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ JavaScript geladen!");

    // ✅ Selecteer elementen
    const accountBtn = document.getElementById("account-btn");
    const loginModal = document.getElementById("login-register-modal");
    const accountModal = document.getElementById("account-modal");
    const loginCloseBtn = loginModal?.querySelector(".login-close-btn");
    const accountCloseBtn = accountModal?.querySelector(".account-close-btn");
    const loginTab = document.getElementById("login-tab");
    const registerTab = document.getElementById("register-tab");
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const registerError = document.getElementById("register-error");
    const logoutBtn = document.getElementById("logout-btn");

    // ✅ Controleer of gebruiker is ingelogd
    const isLoggedIn = document.body.dataset.loggedIn === "true";
    console.log("🔍 isLoggedIn:", isLoggedIn);

    // ✅ Debugging: Check of modals bestaan
    console.log("🔎 Login modal:", loginModal);
    console.log("🔎 Account modal:", accountModal);

    // ✅ Event listener voor de accountknop
    if (accountBtn) {
        accountBtn.addEventListener("click", (e) => {
            e.preventDefault();
            console.log("📌 Account knop geklikt!");

            if (isLoggedIn && accountModal) {
                openModal(accountModal);
            } else if (!isLoggedIn && loginModal) {
                openModal(loginModal);
                showLogin(); // Zorgt ervoor dat login-tab standaard opent
            } else {
                console.error("⚠️ Geen modal gevonden om te openen!");
            }
        });
    }

    function showLogin() {
        if (loginForm && registerForm) {
            loginForm.style.display = "block";  // ✅ Zorg dat loginform zichtbaar is
            registerForm.style.display = "none"; // ✅ Verberg registerform
            loginTab.classList.add("active-tab");
            registerTab.classList.remove("active-tab");
        }
    }
    
    // ✅ Zorg ervoor dat dit automatisch wordt uitgevoerd bij het laden van de modal
    document.addEventListener("DOMContentLoaded", () => {
        if (document.body.dataset.loggedIn === "false") {
            showLogin();
        }
    });

    // ✅ Logout knop (nu correct geconfigureerd)
    if (logoutBtn) {
        logoutBtn.addEventListener("click", (e) => {
            e.preventDefault();
            console.log("🚪 Uitloggen... Gebruiker wordt doorgestuurd!");
            window.location.href = "./pages/logout.php"; // ✅ Stuur gebruiker naar logout pagina
        });
    } else {
        console.warn("⚠️ Logout knop niet gevonden bij pagina-lading. Mogelijk in modal.");
    }

    // ✅ Sluiten van modals
    if (loginCloseBtn) {
        loginCloseBtn.addEventListener("click", () => {
            closeModal(loginModal);
        });
    }

    if (accountCloseBtn) {
        accountCloseBtn.addEventListener("click", () => {
            closeModal(accountModal);
        });
    }

    // ✅ Klik buiten modal om te sluiten
    window.addEventListener("click", (e) => {
        if (e.target === accountModal) closeModal(accountModal);
        if (e.target === loginModal) closeModal(loginModal);
    });

    // ✅ Tab-switching voor login/register modal
    if (loginTab) loginTab.addEventListener("click", showLogin);
    if (registerTab) registerTab.addEventListener("click", showRegister);

    function showLogin() {
        if (loginForm && registerForm) {
            loginForm.style.display = "block";
            registerForm.style.display = "none";
            loginTab.classList.add("active-tab");
            registerTab.classList.remove("active-tab");
        }
    }

    function showRegister() {
        if (loginForm && registerForm) {
            loginForm.style.display = "none";
            registerForm.style.display = "block";
            loginTab.classList.remove("active-tab");
            registerTab.classList.add("active-tab");
        }
    }

    // ✅ Functie om een modal te openen
    function openModal(modal) {
        if (modal) {
            modal.style.display = "flex";
            modal.classList.add("show");
        } else {
            console.error("⚠️ Modal niet gevonden!");
        }
    }

    // ✅ Functie om een modal te sluiten
    function closeModal(modal) {
        if (modal) {
            modal.style.display = "none";
            modal.classList.remove("show");
        }
    }
    
        const profileModal = document.getElementById("profile-edit-modal");
        const profileBtn = document.getElementById("edit-profile-btn"); // Voeg een knop toe om de modal te openen
        const closeBtn = document.querySelector("#profile-edit-modal .close-btn");
    
        if (profileBtn) {
            profileBtn.addEventListener("click", () => {
                profileModal.style.display = "flex";
            });
        }
    
        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                profileModal.style.display = "none";
            });
        }
    
        window.addEventListener("click", (e) => {
            if (e.target === profileModal) {
                profileModal.style.display = "none";
            }
        });
    




    // ✅ AJAX REGISTRATIE
    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(registerForm);
            formData.append("password_confirm", document.getElementById("reg-password-confirm").value);

            fetch("./pages/register.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log("Server response:", data);
                    try {
                        let jsonData = JSON.parse(data);
                        console.log("Parsed JSON:", jsonData);
                        if (jsonData.success) {
                            window.location.href = "./index.php";
                        } else {
                            registerError.innerText = jsonData.message;
                            registerError.style.display = "block";
                        }
                    } catch (e) {
                        console.error("Fout bij JSON verwerken:", e);
                        registerError.innerText = "Fout bij registratie. Probeer opnieuw.";
                        registerError.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    registerError.innerText = "Er is een fout opgetreden. Probeer opnieuw.";
                    registerError.style.display = "block";
                });
        });
    }

    
// ============================
// ✅ POKÉMON MODAL FIXED ✅
// ============================

    const pokemonModal = document.getElementById("pokemon-modal");
    const pokemonModalContent = document.getElementById("pokemon-modal-content");
    const modalPokemonId = document.getElementById("modal-pokemon-id");
    const pokemonCloseBtn = document.querySelector(".pokemon-close-btn");

    if (pokemonCloseBtn) {
        pokemonCloseBtn.addEventListener("click", () => {
            console.log("❌ Modal gesloten!");
            pokemonModal.style.display = "none";
        });
    }

    document.querySelectorAll(".pokemon-card").forEach((card) => {
        card.addEventListener("click", function () {
            console.log("📌 Klik op een Pokémon gedetecteerd!");

            // ✅ Haal data op van de aangeklikte Pokémon
            const pokemonId = this.getAttribute("data-number") || "???";
            const pokemonName = this.getAttribute("data-name") || "Onbekend";
            const pokemonImage = this.getAttribute("data-image") || "./assets/placeholder.png";
            const pokemonType = this.getAttribute("data-type") || "Onbekend";
            const pokemonDescription = this.getAttribute("data-description") || "Geen beschrijving beschikbaar";
            const pokemonGender = this.getAttribute("data-gender") || "Onbekend";
            const pokemonHeight = this.getAttribute("data-height") || "Onbekend";
            const pokemonWeight = this.getAttribute("data-weight") || "Onbekend";
            const pokemonAbilities = this.getAttribute("data-abilities") || "Onbekend";

            console.log("🎯 Geselecteerde Pokémon:", pokemonName, "| ID:", pokemonId);

            // ✅ Zet het Pokémon ID in de verborgen input voor het formulier
            if (modalPokemonId) {
                modalPokemonId.value = pokemonId;
            }

            // ✅ Type badges kleuren instellen
            const typeBadges = pokemonType.split(" & ").map(t => {
                const typeClass = "type-" + t.trim().toLowerCase();
                return `<span class="type-badge ${typeClass}">${t.trim()}</span>`;
            }).join(" ");

            // ✅ Geslacht badge kleuren instellen
            let genderClass = "gender-onbekend";
            if (pokemonGender.toLowerCase() === "mannelijk") genderClass = "gender-mannelijk";
            if (pokemonGender.toLowerCase() === "vrouwelijk") genderClass = "gender-vrouwelijk";

            // ✅ Abilities badge kleuren instellen
            const abilityBadges = pokemonAbilities.split(",").map(a => {
                const abilityClass = "ability-" + pokemonType.toLowerCase().split(" & ")[0]; // Eerste type gebruiken
                return `<span class="ability-badge ${abilityClass}">${a.trim()}</span>`;
            }).join(" ");

            // ✅ Vul de modal met Pokémon details
            pokemonModalContent.innerHTML = `
                <h3>${pokemonName} <span style="color:gray;">#${pokemonId}</span></h3>
                <img src="${pokemonImage}" alt="${pokemonName}">
                <p><strong>Type:</strong> ${typeBadges}</p>
                <p><strong>Beschrijving:</strong> ${pokemonDescription}</p>
                <p><strong>Geslacht:</strong> <span class="gender-badge ${genderClass}">${pokemonGender}</span></p>
                <p><strong>Hoogte:</strong> ${pokemonHeight}</p>
                <p><strong>Gewicht:</strong> ${pokemonWeight}</p>
                <p><strong>Abilities:</strong> ${abilityBadges}</p>
            `;

            // ✅ Open de modal
            console.log("✅ Modal wordt geopend!");
            pokemonModal.style.display = "flex";
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const pokemonModal = document.getElementById("pokemon-modal");
        const modalPokemonId = document.getElementById("modal-pokemon-id");
        const collectieBtn = document.getElementById("collectie-btn");
        const collectionForm = document.getElementById("collection-form");
    
        document.querySelectorAll(".pokemon-card").forEach((card) => {
            card.addEventListener("click", function () {
                const pokemonId = parseInt(this.getAttribute("data-number"));
                modalPokemonId.value = pokemonId;
    
                // ✅ Controleer of de Pokémon al in de collectie zit
                const inCollection = userCollection.includes(pokemonId);
    
                // ✅ Pas knoptekst en formulieractie aan
                if (inCollection) {
                    collectieBtn.innerText = "Verwijderen uit collectie";
                    collectionForm.action = "./pages/remove_from_collection.php";
                } else {
                    collectieBtn.innerText = "Toevoegen aan collectie";
                    collectionForm.action = "./pages/add_to_collection.php";
                }
    
                // ✅ Open de modal
                pokemonModal.style.display = "flex";
            });
        });
    });
    

    // ============================
    // SEARCH FUNCTION
    // ============================
    const searchBar = document.getElementById('search-bar');
    if (searchBar) {
        searchBar.addEventListener('keyup', () => {
            const input = searchBar.value.toLowerCase();
            const cards = document.querySelectorAll('.pokemon-card');
            let found = 0;

            cards.forEach(card => {
                const name = card.querySelector('h3').innerText.toLowerCase();
                if (name.includes(input)) {
                    card.style.display = 'block';
                    found++;
                } else {
                    card.style.display = 'none';
                }
            });

            document.getElementById('no-results').style.display = found === 0 ? 'block' : 'none';
        });
    }

    // ============================
    // FILTER FUNCTION
    // ============================
    document.getElementById('type-filter').addEventListener('change', filterPokemons);

    function filterPokemons() {
        const selectedType = document.getElementById('type-filter').value;
        const pokemonTitle = document.getElementById('pokemon-title');
        const cards = document.querySelectorAll('.pokemon-card');
    
        pokemonTitle.innerText = selectedType === 'all'
            ? 'Alle Pokémons'
            : `${selectedType === 'ijs' ? 'Ice' : capitalize(selectedType)} Pokémons`;
    
        cards.forEach(card => {
            const typeElement = card.querySelector('.type');
            const typeClasses = typeElement.className.split(' ');
            const hasType = selectedType === 'all' || typeClasses.includes('type-' + selectedType);
            card.style.display = hasType ? 'block' : 'none';
        });
    }
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
        


    // ============================
    // LOGIN FORM LOADER
    // ============================
    const loginBtn = document.getElementById('login-btn');
    const pokeballLoader = document.getElementById('pokeball-loader');

    if (loginForm && loginBtn && pokeballLoader) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Voorkomt direct versturen

            // Pokéball tonen en knop uitschakelen
            pokeballLoader.style.display = 'flex';
            loginBtn.disabled = true;
            loginBtn.innerText = 'Bezig met inloggen...';

            // Wacht 2 seconden (2000 ms) en verstuur daarna het formulier
            setTimeout(() => {
                loginForm.submit(); // Formulier nu echt versturen
            }, 2000);
        });
    }})

    function updateFileName() {
        const fileInput = document.getElementById("avatar");
        const fileName = document.getElementById("file-name");
        
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
        } else {
            fileName.textContent = "Geen bestand gekozen";
        }
    }
    