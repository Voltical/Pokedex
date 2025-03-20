document.addEventListener('DOMContentLoaded', () => {
    // ============================
    // LOGIN & REGISTER MODAL
    // ============================
    const accountBtn = document.getElementById('account-btn');
    const loginModal = document.getElementById('login-register-modal');
    const loginCloseBtn = loginModal?.querySelector('.login-close-btn');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const registerError = document.getElementById("register-error");

    if (accountBtn) {
        accountBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loginModal.style.display = 'flex';
            showLogin();
        });
    }
    

    if (loginCloseBtn) {
        loginCloseBtn.addEventListener('click', () => {
            loginModal.style.display = 'none';
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target === loginModal) loginModal.style.display = 'none';
    });

    loginTab?.addEventListener('click', showLogin);
    registerTab?.addEventListener('click', showRegister);

    function showLogin() {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        loginTab.classList.add('active-tab');
        registerTab.classList.remove('active-tab');
    }

    function showRegister() {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        loginTab.classList.remove('active-tab');
        registerTab.classList.add('active-tab');
    }

    // ============================
    // AJAX REGISTRATIE
    // ============================
    if (registerForm) {
        registerForm.addEventListener("submit", function(event) {
            event.preventDefault();

            let formData = new FormData(registerForm);
            formData.append("password_confirm", document.getElementById("reg-password-confirm").value);

            fetch("./pages/register.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text()) // Eerst uitlezen als tekst
            .then(data => {
                console.log("Server response:", data); // Debugging: toon volledige server response
                try {
                    let jsonData = JSON.parse(data);
                    console.log("Parsed JSON:", jsonData); // Debugging JSON
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
            .then(data => {
                console.log("Server response:", data); // Debugging
                try {
                    let jsonData = JSON.parse(data);
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
    // POKÉMON MODAL
    // ============================
    const pokemonModal = document.getElementById('pokemon-modal');
    const pokemonCloseBtn = pokemonModal?.querySelector('.pokemon-close-btn');

    if (pokemonCloseBtn) {
        pokemonCloseBtn.addEventListener('click', () => {
            pokemonModal.style.display = 'none';
        });
    }

    if (pokemonModal) {
        pokemonModal.addEventListener('click', (e) => {
            if (e.target === pokemonModal) pokemonModal.style.display = 'none';
        });
    }

    document.querySelectorAll('.pokemon-card').forEach(card => {
        card.addEventListener('click', function () {
            const { name, number, image, type, description, gender, height, weight, abilities } = this.dataset;
            const firstType = type.split(' & ')[0].trim().toLowerCase();

            let genderClass = 'gender-onbekend';
            if (gender.toLowerCase() === 'mannelijk') genderClass = 'gender-man';
            else if (gender.toLowerCase() === 'vrouwelijk') genderClass = 'gender-vrouw';

            const typeList = type.split(' & ').map(t =>
                `<span class="type-badge type-${t.trim().toLowerCase()}">${t.trim()}</span>`
            ).join(' ');

            const abilityList = abilities.split(',').map(a =>
                `<span class="ability-badge ability-${firstType}">${a.trim()}</span>`
            ).join(' ');

            const modalContent = `
                <h3>${name} <span style="color:gray;">#${number}</span></h3>
                <img src="${image}" alt="${name}">
                <p><strong>Type:</strong> ${typeList}</p>
                <p><strong>Beschrijving:</strong> ${description}</p>
                <p><strong>Geslacht:</strong> <span class="gender-badge ${genderClass}">${gender}</span></p>
                <p><strong>Hoogte:</strong> ${height}</p>
                <p><strong>Gewicht:</strong> ${weight}</p>
                <p><strong>Abilities:</strong> ${abilityList}</p>
            `;
            document.getElementById('pokemon-modal-content').innerHTML = modalContent;
            pokemonModal.style.display = 'flex';
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
    }
});
