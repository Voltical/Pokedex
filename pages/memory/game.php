<?php
session_start();

if (!isset($_SESSION['cards'])) {
    $pokemons = ['pikachu', 'charmander', 'bulbasaur', 'squirtle', 'eevee', 'jigglypuff'];
    $cards = array_merge($pokemons, $pokemons); // Dubbele set kaarten
    shuffle($cards);
    $_SESSION['cards'] = $cards;
    $_SESSION['flipped'] = array_fill(0, count($cards), false);
    $_SESSION['matched'] = [];
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Memory</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>
<body>
    <h1>Pokémon Memory</h1>
    <div class="memory-game">
        <?php foreach ($_SESSION['cards'] as $index => $pokemon): ?>
            <div class="card" data-index="<?= $index ?>">
                <img src="images/<?= $pokemon ?>.png" class="hidden" alt="<?= $pokemon ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <a href="index.php" class="restart-button">Opnieuw Spelen</a>
</body>
</html>
