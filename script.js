document.addEventListener('DOMContentLoaded', () => {
    // ============================
    // LOGIN & REGISTER MODAL
    // ============================
    const accountBtn = document.getElementById('account-btn');
    const loginModal = document.getElementById('login-register-modal');
    const loginCloseBtn = loginModal.querySelector('.login-close-btn');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    accountBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loginModal.style.display = 'flex';
        showLogin();
    });

    loginCloseBtn.addEventListener('click', () => {
        loginModal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === loginModal) loginModal.style.display = 'none';
    });

    loginTab.addEventListener('click', showLogin);
    registerTab.addEventListener('click', showRegister);

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
    // POKÉMON MODAL
    // ============================
    const pokemonModal = document.getElementById('pokemon-modal');
    const pokemonCloseBtn = pokemonModal.querySelector('.pokemon-close-btn');

    pokemonCloseBtn.addEventListener('click', () => {
        pokemonModal.style.display = 'none';
    });

    pokemonModal.addEventListener('click', (e) => {
        if (e.target === pokemonModal) pokemonModal.style.display = 'none';
    });

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
    // TYPE CONVERSIE & KLEUREN
    // ============================
    document.querySelectorAll('.pokemon-type').forEach(el => {
        const types = el.dataset.types.split(',');
        el.innerText = types.map(t => t.charAt(0).toUpperCase() + t.slice(1)).join(' & ');
        types.forEach(type => el.classList.add('type-' + type.trim().toLowerCase()));
        if (types.length > 1) el.classList.add('multi-type');
    });

    // ============================
    // SEARCH FUNCTION
    // ============================
    document.getElementById('search-bar').addEventListener('keyup', () => {
        const input = document.getElementById('search-bar').value.toLowerCase();
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

    // ============================
    // FILTER FUNCTION
    // ============================
    document.getElementById('type-filter').addEventListener('change', () => {
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
    });

    // ============================
    // Helper voor hoofdletter
    // ============================
    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const loginBtn = document.getElementById('login-btn');
    const pokeballLoader = document.getElementById('pokeball-loader');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Voorkomt direct versturen

        // Pokéball tonen en knop uitschakelen
        pokeballLoader.style.display = 'flex';
        loginBtn.disabled = true;
        loginBtn.innerText = 'Bezig met inloggen...';

        // Wacht 2 seconden (2000 ms) en verstuur daarna het formulier
        setTimeout(() => {
            loginForm.submit(); // Formulier nu echt versturen
        }, 2000); // Tijd in milliseconden
    });
});
