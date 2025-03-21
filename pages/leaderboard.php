<?php
session_start();
require_once '../Includes/database.inc.php';
use Includes\Database;

// ✅ Haal top gebruikers op (bijvoorbeeld gesorteerd op verzamelde Pokémon)
$query = "SELECT u.username, COUNT(up.pokemon_number) AS total_pokemon 
          FROM users u
          LEFT JOIN user_pokemon up ON u.id = up.user_id
          GROUP BY u.id
          ORDER BY total_pokemon DESC
          LIMIT 10"; // Top 10 spelers

$leaderboard = Database::getData($query);
?>

<div class="leaderboard">
    <h2>🏆 Leaderboard</h2>
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
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= $user['total_pokemon'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
