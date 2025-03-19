<?php
session_start();

require_once '../Includes/database.inc.php';
use Includes\Database;

// Check of gebruiker is ingelogd
$isLoggedIn = isset($_SESSION['user_id']); // Of andere login check
// URL naar juiste pagina
$accountLink = $isLoggedIn ? '../pages/account.php' : '../pages/login.php';
// Icoon afhankelijk van login
$accountIcon = $isLoggedIn ? '../assets/user.png' : '../assets/favicon.png';
// Tekst afhankelijk van login
$accountText = $isLoggedIn ? 'Account' : 'Login';


$pokemonQuery = "SELECT * FROM pokemons ORDER BY number ASC";
$pokemons = Database::getData($pokemonQuery);

$typeColors = [
    'vuur' => '#FC7C24',
    'water' => '#6890F0',
    'gras' => '#78C850',
    'elektro' => '#EED535',
    'psychic' => '#F85888',
    'ijs' => '#98D8D8',
    'dragon' => '#7038F8',
    'dark' => '#705848',
    'fairy' => '#EE99AC',
    'fighting' => '#C03028',
    'poison' => '#A040A0',
    'ground' => '#E0C068',
    'vliegend' => '#A890F0',
    'bug' => '#739F3E',
    'rock' => '#B8A038',
    'ghost' => '#705898',
    'steel' => '#B8B8D0',
    'normaal' => '#A4ACAF'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokédex | Home</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="hero">
        <!-- Navbar -->
        <div class="navbar container">
            <a href="#">
                <img src="../assets/logo.png" alt="Pokédex Logo" class="logo">
            </a>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Pokémons</a></li>
                <li><a href="#">Contact</a></li>
                <li>
                    <a href="#" class="account-link" id="account-btn">
                        <img src="<?php echo $accountIcon; ?>" alt="<?php echo $accountText; ?>" width="32" height="32">
                    </a>
                </li>

            </ul>
        </div>

        <img src="../assets/charmander.png" alt="Charmander" class="side-pokemon left">
        <img src="../assets/fat_pikachy.png" alt="Pikachu" class="side-pokemon right">

        <!-- Pokémon groep -->
        <div class="pokemon-container container">
            <div class="pokemon-group">
                <div class="pokemon-header">
                    <h2 id="pokemon-title">Alle Pokémons</h2>
                    <div class="filter-search-group">
                        <select id="type-filter" onchange="filterPokemons()">
                            <option value="all">Alle types</option>
                            <?php foreach ($typeColors as $type => $color): ?>
                                <option value="<?= htmlspecialchars($type) ?>">
                                    <?= $type === 'ijs' ? 'Ice' : ucfirst($type) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" id="search-bar" placeholder="Zoek een Pokémon..." onkeyup="searchPokemon()">
                    </div>
                </div>

                <div class="pokemon-grid">
                    <?php if (empty($pokemons)): ?>
                        <p class="no-results">Geen Pokémons gevonden in de database.</p>
                    <?php else: ?>
                        <?php foreach ($pokemons as $pokemon): ?>
                            <?php
                                $types = array_map('trim', explode(',', $pokemon['type']));
                                $typeClasses = implode(' ', array_map(fn($t) => 'type-' . strtolower($t), $types));
                                $typeDisplay = implode(' & ', array_map('ucfirst', $types));
                                $colors = array_map(fn($t) => $typeColors[strtolower($t)] ?? '#000', $types);
                                $style = count($colors) > 1
                                    ? '--color1: '.$colors[0].'; --color2: '.$colors[1].';'
                                    : '--color1: '.$colors[0].'; --color2: '.$colors[0].';';
                            ?>
                            <div class="pokemon-card" data-name="<?= htmlspecialchars($pokemon['name']) ?>" data-number="<?= str_pad($pokemon['number'], 3, '0', STR_PAD_LEFT) ?>" data-image="<?= htmlspecialchars($pokemon['image_url']) ?>" data-type="<?= $typeDisplay ?>" data-description="<?= htmlspecialchars($pokemon['description'] ?: '') ?>" data-gender="<?= htmlspecialchars($pokemon['gender'] ?: 'Onbekend') ?>" data-height="<?= htmlspecialchars($pokemon['height'] ?: 'Onbekend') ?>" data-weight="<?= htmlspecialchars($pokemon['weight'] ?: 'Onbekend') ?>" data-abilities="<?= htmlspecialchars($pokemon['abilities'] ?: 'Onbekend') ?>">
                                <div class="pokemon-number">#<?= str_pad($pokemon['number'], 3, '0', STR_PAD_LEFT) ?></div>
                                <img src=".<?=htmlspecialchars($pokemon['image_url']) ?>" alt="<?= htmlspecialchars($pokemon['name']) ?>">
                                <div class="divider-line"></div>
                                <div class="pokemon-info">
                                    <h3><?= htmlspecialchars($pokemon['name']) ?></h3>
                                    <p class="type <?= $typeClasses ?>" style="<?= $style ?>">
                                        <?= $pokemon['type'] ? $typeDisplay : 'Onbekend' ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <p id="no-results" class="no-results" style="display: none;">Geen resultaten gevonden.</p>
            </div>
        </div>
    </div>

    <div id="pokemon-modal" class="modal">
    <div class="modal-content">
        <span class="pokemon-close-btn">&times;</span> <!-- Unieke class hier -->
        <div id="pokemon-modal-content">
            <!-- Dynamische inhoud hier -->
        </div>
    </div>
</div>


<div id="login-register-modal" class="modal">
    <div class="modal-content">
        <span class="login-close-btn">&times;</span> <!-- Unieke class hier -->
        <div class="tab-header">
            <button id="login-tab" class="active-tab">Inloggen</button>
            <button id="register-tab">Registreren</button>
        </div>

        <!-- Login Form -->
        <form id="login-form" method="POST" action="../pages/login.php">
            <h2>Inloggen</h2>
            <input type="text" name="gebruikersnaam_email" placeholder="Gebruikersnaam of E-mail" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
            <button type="submit" id="login-btn">Inloggen</button>

            <!-- Pokéball animatie -->
            <div id="pokeball-loader" class="pokeball-loader" style="display: none;">
                <img src="../assets/favicon.png" alt="Loading">
            </div>
        </form>


        <!-- Register Form -->
        <form id="register-form" method="POST" action="../pages/register.php" style="display: none;">
            <h2>Registreren</h2>
            <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
            <input type="password" name="wachtwoord_confirm" placeholder="Herhaal wachtwoord" required>
            <button type="submit">Registreren</button>
        </form>
    </div>
</div>



<script src="../script.js"></script>
<script src="https://kit.fontawesome.com/bb89b598a6.js" crossorigin="anonymous"></script>
</body>
</html>
