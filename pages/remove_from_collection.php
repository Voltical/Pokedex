<?php
session_start();
require_once '../Includes/database.inc.php';
use Includes\Database;

if (!isset($_SESSION['user_id'])) {
    die("❌ Je moet ingelogd zijn om een Pokémon te verwijderen.");
}

$userId = $_SESSION['user_id'];
$pokemonNumber = isset($_POST['pokemon_id']) ? (int)$_POST['pokemon_id'] : null;

if (!$pokemonNumber) {
    die("❌ Ongeldige Pokémon ID ontvangen!");
}

try {
    $pdo = Database::getConnection();

    // ✅ Controleer of de Pokémon daadwerkelijk in de collectie zit
    $stmt = $pdo->prepare("DELETE FROM user_pokemon WHERE user_id = ? AND pokemon_number = ?");
    $stmt->execute([$userId, $pokemonNumber]);

    if ($stmt->rowCount() > 0) {
        $_SESSION['message'] = "✅ Pokémon succesvol verwijderd!";
    } else {
        $_SESSION['message'] = "⚠️ Pokémon niet gevonden in je collectie.";
    }

    // ✅ Redirect na verwijdering
    header("Location: ../index.php");
    exit;

} catch (PDOException $e) {
    die("❌ Databasefout: " . $e->getMessage());
}
