<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");

require_once "Includes/database.inc.php";
use Includes\Database;

// Check of gebruiker is ingelogd
$isLoggedIn = isset($_SESSION["user_id"]); // ✅ Check of gebruiker ingelogd is
// URL naar juiste pagina
$accountLink = $isLoggedIn ? "./pages/account.php" : "./pages/login.php";
// Icoon afhankelijk van login
$accountIcon = $isLoggedIn ? "./assets/user.png" : "./assets/favicon.png";
// Tekst afhankelijk van login
$accountText = $isLoggedIn ? "Account" : "Login";

$profilePicture = $_SESSION["avatar"] ?? "./assets/default-avatar.png";

if ($isLoggedIn && isset($_GET["collection"])) {
    $userId = $_SESSION["user_id"];
    $pokemonQuery = "SELECT p.* FROM pokemons p
                     INNER JOIN user_pokemon up ON p.number = up.pokemon_number
                     WHERE up.user_id = ?";
    $pokemons = Database::getData($pokemonQuery, [$userId]);
    $pageTitle = "Mijn Collectie";
} elseif ($isLoggedIn && isset($_GET["leaderboard"])) {
    $pageTitle = "Leaderboard";

    // ✅ Haal de top 10 gebruikers op gesorteerd op het aantal gevangen Pokémon
    $leaderboardQuery = "SELECT u.username, COUNT(up.pokemon_number) AS total_pokemon 
                         FROM users u
                         LEFT JOIN user_pokemon up ON u.id = up.user_id
                         GROUP BY u.id
                         ORDER BY total_pokemon DESC
                         LIMIT 10"; // Top 10 spelers
    $leaderboard = Database::getData($leaderboardQuery);
} elseif (isset($_GET["contact"])) {
    $pageTitle = "Contact";
} else {
    $pokemonQuery = "SELECT * FROM pokemons ORDER BY number ASC";
    $pokemons = Database::getData($pokemonQuery);
    $pageTitle = "Alle Pokémons";
}

$pokemonInCollection = false; // Standaard false

if ($isLoggedIn && isset($_GET["pokemon_id"])) {
    $pokemonId = $_GET["pokemon_id"];

    // ✅ Controleer of de Pokémon al in de collectie van de gebruiker zit
    $query = "SELECT COUNT(*) AS count FROM user_pokemon WHERE user_id = ? AND pokemon_number = ?";
    $result = Database::getData($query, [$userId, $pokemonId]);

    if ($result[0]["count"] > 0) {
        $pokemonInCollection = true;
    }
}

$typeColors = [
    "vuur" => "#FC7C24",
    "water" => "#6890F0",
    "gras" => "#78C850",
    "elektro" => "#EED535",
    "psychic" => "#F85888",
    "ijs" => "#98D8D8",
    "dragon" => "#7038F8",
    "dark" => "#705848",
    "fairy" => "#EE99AC",
    "fighting" => "#C03028",
    "poison" => "#A040A0",
    "ground" => "#E0C068",
    "vliegend" => "#A890F0",
    "bug" => "#739F3E",
    "rock" => "#B8A038",
    "ghost" => "#705898",
    "steel" => "#B8B8D0",
    "normaal" => "#A4ACAF",
];
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pokédex | Home</title>
    <link rel="stylesheet" href="./style/style.css">
    <link rel="shortcut icon" href="./assets/favicon.png" type="image/x-icon">
</head>
<body data-logged-in="<?= $isLoggedIn ? "true" : "false" ?>">
    <div class="hero">
        <!-- Navbar -->
        <div class="navbar container">
            <a href="./index.php">
                <img src="./assets/logo.png" alt="Pokédex Logo" class="logo">
            </a>
            <ul>
                <li><a href="./index.php" id="home-btn">Home</a></li>
                <li><a href="./index.php?collection">Collectie</a></li>
                <li><a href="./index.php?leaderboard">Leaderboard</a></li>
                <li><a href="./index.php?contact">Contact</a></li>
                <li>
                    <a href="#" class="account-link" id="account-btn">
                        <img src="<?= isset($_SESSION["user_id"]) ? $_SESSION["avatar"] ?? "./assets/user.png" : "./assets/favicon.png" ?>" 
                            alt="Profielfoto" width="32" height="32">
                    </a>
                </li>
            </ul>
        </div>

        <img src="./assets/charmander.png" alt="Charmander" class="side-pokemon left">
        <img src="./assets/fat_pikachy.png" alt="Pikachu" class="side-pokemon right">

<!-- Pokémon groep -->

<div class="pokemon-container container">
    <div class="pokemon-group">
        <div class="pokemon-header">
            <h2 id="pokemon-title"><?= $pageTitle ?></h2>

            <!-- ✅ Contactpagina weergeven -->
            <?php if (isset($_GET["contact"])): ?>
                <div class="contact-container">
                    <h2>📩 Neem Contact Op</h2>
                    <p>Heb je vragen of opmerkingen? Vul dan het formulier hieronder in en wij nemen zo snel mogelijk contact met je op!</p>

                    <form action="./pages/send_contact.php" method="POST">
                        <label for="name">Naam:</label>
                        <input type="text" id="name" name="name" autocomplete="off" required>

                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" autocomplete="off" required>

                        <label for="message">Bericht:</label>
                        <textarea id="message" name="message" autocomplete="off" required></textarea>

                        <button type="submit">Verstuur</button>
                    </form>
                </div>

            <!-- ✅ Leaderboardpagina weergeven -->
            <?php elseif (isset($_GET["leaderboard"])): ?>
                <div class="leaderboard">
                    <h2>🏆 Leaderboard 🏆</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Plek</th>
                                <th>Gebruiker</th>
                                <th>Aantal Pokémon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaderboard as $index => $user): ?>
                                <tr>
                                    <td>#<?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($user["username"]) ?></td>
                                    <td><?= $user["total_pokemon"] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <!-- ✅ Pokémonlijst weergeven als er GEEN contact of leaderboard geselecteerd is -->
            <?php else: ?>
                <div class="filter-search-group">
                    <select id="type-filter">
                        <option value="all">Alle types</option>
                        <?php foreach ($typeColors as $type => $color): ?>
                            <option value="<?= htmlspecialchars($type) ?>">
                                <?= $type === "ijs" ? "Ice" : ucfirst($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" id="search-bar" placeholder="Zoek een Pokémon..." onkeyup="searchPokemon()">
                </div>

                <div class="pokemon-grid">
                    <?php if (empty($pokemons)): ?>
                        <p class="no-results">Geen Pokémons gevonden in de database.</p>
                    <?php else: ?>
                        <?php foreach ($pokemons as $pokemon): ?>
                            <?php
                            $types = array_map("trim", explode(",", $pokemon["type"]));
                            $typeClasses = implode(" ", array_map(fn($t) => "type-" . strtolower($t), $types));
                            $typeDisplay = implode(" & ", array_map("ucfirst", $types));
                            $colors = array_map(fn($t) => $typeColors[strtolower($t)] ?? "#000", $types);
                            $style = count($colors) > 1 ? "--color1: " . $colors[0] . "; --color2: " . $colors[1] . ";" : "--color1: " . $colors[0] . "; --color2: " . $colors[0] . ";";
                            ?>
                            <div class="pokemon-card"
                                 data-name="<?= htmlspecialchars($pokemon["name"]) ?>"
                                 data-number="<?= str_pad($pokemon["number"], 3, "0", STR_PAD_LEFT) ?>"
                                 data-image="<?= htmlspecialchars($pokemon["image_url"]) ?>"
                                 data-type="<?= $typeDisplay ?>"
                                 data-description="<?= htmlspecialchars($pokemon["description"] ?: "") ?>"
                                 data-gender="<?= htmlspecialchars($pokemon["gender"] ?: "Onbekend") ?>"
                                 data-height="<?= htmlspecialchars($pokemon["height"] ?: "Onbekend") ?>"
                                 data-weight="<?= htmlspecialchars($pokemon["weight"] ?: "Onbekend") ?>"
                                 data-abilities="<?= htmlspecialchars($pokemon["abilities"] ?: "Onbekend") ?>">
                                <div class="pokemon-number">#<?= str_pad($pokemon["number"], 3, "0", STR_PAD_LEFT) ?></div>
                                <img src="<?= htmlspecialchars($pokemon["image_url"]) ?>" alt="<?= htmlspecialchars($pokemon["name"]) ?>">
                                <div class="divider-line"></div>
                                <div class="pokemon-info">
                                    <h3><?= htmlspecialchars($pokemon["name"]) ?></h3>
                                    <p class="type <?= $typeClasses ?>" style="<?= $style ?>">
                                        <?= $pokemon["type"] ? $typeDisplay : "Onbekend" ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

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
        <?php if ($isLoggedIn): ?>
            <form method="POST" action="./pages/add_to_collection.php" id="add-to-collection-form">
                <input type="hidden" name="pokemon_id" id="modal-pokemon-id">
                <button type="submit" id="collectie-btn">Toevoegen aan collectie</button>
            </form>
        <?php endif; ?>
    </div>

</div>

            <!-- ✅ Account modal tonen als ingelogd -->
            <?php if ($isLoggedIn): ?>
                <div id="account-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <h2>Mijn account</h2>

                        <!-- ✅ Profielfoto -->
                        <img id="account-avatar" src="<?= $_SESSION["avatar"] ?? "./assets/user.png" ?>" alt="Profielfoto">

                        <!-- ✅ Gebruikersnaam -->
                        <p>Gebruikersnaam: <strong><?= $_SESSION["username"] ?? "Onbekend" ?></strong></p>

                        <!-- ✅ Bewerken Knop -->
                        <button id="edit-profile-btn">Bewerken</button>

                        <!-- ✅ Uitlogknop -->
                        <button id="logout-btn">Uitloggen</button>
                    </div>
                </div>
            <?php endif; ?>

            <div id="login-register-modal" class="modal">
                <div class="modal-content">
                    <span class="login-close-btn">&times;</span>
                    <div class="tab-header">
                        <button id="login-tab" class="active-tab">Inloggen</button>
                        <button id="register-tab">Registreren</button>
                    </div>

                    <!-- ✅ Login Form -->
                    <form id="login-form" method="POST" action="./pages/login.php">
                        <input type="text" name="gebruikersnaam_email" placeholder="Gebruikersnaam of E-mail" required>
                        <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
                        <button type="submit">Inloggen</button>
                    </form>

                    <!-- ✅ Register Form -->
                    <form id="register-form" style="display: none;"> <!-- ✅ Start als verborgen -->
                        <input type="text" id="reg-username" name="username" placeholder="Gebruikersnaam" required>
                        <input type="email" id="reg-email" name="email" placeholder="E-mail" required>
                        <input type="password" id="reg-password" name="password" placeholder="Wachtwoord" required>
                        <input type="password" id="reg-password-confirm" name="password_confirm" placeholder="Herhaal wachtwoord" required>
                        <button type="submit">Registreren</button>
                    </form>
                </div>
            </div>

    <!-- ✅ Profiel Bewerken Modal -->
    <div id="profile-edit-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Profiel bewerken</h2>

            <form id="profile-edit-form" action="./pages/update_profile.php" method="POST" enctype="multipart/form-data">
                <!-- ✅ Nieuwe gebruikersnaam -->
                <label for="new_username">Nieuwe gebruikersnaam:</label>
                <input type="text" id="new_username" name="new_username" placeholder="<?= $_SESSION["username"] ?? "Onbekend" ?>">

                <!-- ✅ Nieuwe e-mail -->
                <label for="new_email">Nieuwe e-mail:</label>
                <input type="email" id="new_email" name="new_email" placeholder="<?= $_SESSION["email"] ?? "Onbekend" ?>">

                <!-- ✅ Wachtwoord wijzigen -->
                <label for="new_password">Nieuw wachtwoord:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Wachtwoord">

                <!-- ✅ Bevestig nieuw wachtwoord -->
                <label for="confirm_password">Bevestig wachtwoord:</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Wachtwoord herhalen">

                <!-- ✅ Nieuwe profielfoto -->
                <label for="avatar">Nieuwe profielfoto:</label>
                <div class="file-upload">
                    <button type="button">📁 Kies een bestand</button>
                    <span id="file-name">Geen bestand gekozen</span>
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="updateFileName()">
                </div>


                <button type="submit">Opslaan</button>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION["login_error"])) {
        echo "document.getElementById('login-error').innerText = '{$_SESSION["login_error"]}';";
        unset($_SESSION["login_error"]);
    }
    if (isset($_SESSION["register_error"])) {
        echo "document.getElementById('register-error').innerText = '{$_SESSION["register_error"]}';";
        unset($_SESSION["register_error"]);
    }
    if (isset($_SESSION["register_success"])) {
        echo "document.getElementById('login-error').innerText = '{$_SESSION["register_success"]}';";
        unset($_SESSION["register_success"]);
    }
    ?>
});
<script src="./script.js"></script>

<script
  src="https://kit.fontawesome.com/bb89b598a6.js"
  crossorigin="anonymous"
></script>

</body>
</html>