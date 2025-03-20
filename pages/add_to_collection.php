<?php
session_start();
require_once '../Includes/database.inc.php';
use Includes\Database;

// ✅ Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    die("❌ Je moet ingelogd zijn om een Pokémon toe te voegen.");
}

$userId = $_SESSION['user_id']; // Huidige ingelogde gebruiker
$pokemonNumber = isset($_POST['pokemon_id']) ? (int) $_POST['pokemon_id'] : null; // 🛠 Veranderde 'pokemon_id' naar 'pokemon_number'

if (!$pokemonNumber) {
    die("❌ Ongeldige Pokémon Number ontvangen!");
}

try {
    // ✅ Maak verbinding met de database
    $pdo = Database::getConnection();

    // ✅ Controleer of de Pokémon bestaat in de database
    $stmt = $pdo->prepare("SELECT number FROM pokemons WHERE number = ?");
    $stmt->execute([$pokemonNumber]);
    $existingPokemon = $stmt->fetchColumn();

    if (!$existingPokemon) {
        die("❌ De geselecteerde Pokémon bestaat niet!");
    }

    // ✅ INSERT query om Pokémon aan collectie toe te voegen
    $stmt = $pdo->prepare("INSERT INTO user_pokemon (user_id, pokemon_number) VALUES (?, ?)");
    $success = $stmt->execute([$userId, $pokemonNumber]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = "✅ Pokémon succesvol toegevoegd!";
    } else {
        $_SESSION['message'] = "⚠️ Pokémon is NIET toegevoegd (mogelijk al in de collectie?).";
    }

    // ✅ Redirect naar index.php na het toevoegen
    header("Location: ../index.php");
    exit;

} catch (PDOException $e) {
    die("❌ Databasefout: " . $e->getMessage());
}
