<?php
session_start();
require_once '../Includes/database.inc.php';
use Includes\Database;

// ✅ Haal top gebruikers op (bijvoorbeeld gesorteerd op verzamelde Pokémon)
$query = "SELECT u.username, u.avatar, COUNT(up.pokemon_number) AS total_pokemon 
          FROM users u
          LEFT JOIN user_pokemon up ON u.id = up.user_id
          GROUP BY u.id
          ORDER BY total_pokemon DESC
          LIMIT 10";


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
                <td>
                <?php
                $avatarPath = '/pokedex/' . ltrim($user['avatar'], './');
                echo '<p>PAD: ' . $avatarPath . '</p>';
                ?>
                <img src="<?= $avatarPath ?>" alt="Profielfoto" class="leaderboard-avatar">
                <?= htmlspecialchars($user['username']) ?>
                </td>
                <td><?= $user['total_pokemon'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
