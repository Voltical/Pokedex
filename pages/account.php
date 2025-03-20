<?php
require_once '../Includes/auth.inc.php'; // Eerst sessie check!
require_once '../Includes/database.inc.php'; // Daarna database
use Includes\Database;

$user_id = $_SESSION['user_id'];

// Profielgegevens ophalen
$sql = "
    SELECT u.username, u.email, up.avatar_url, up.bio 
    FROM users u
    LEFT JOIN user_profiles up ON u.id = up.user_id
    WHERE u.id = ?
";
$profiel = Database::getData($sql, [$user_id]);

if (count($profiel) === 0) {
    die('Gebruiker niet gevonden.');
}
$gebruiker = $profiel[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex | Profiel</title>
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
</head>
<body>
    <h2>Welkom, <?= htmlspecialchars($gebruiker['username']) ?></h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($gebruiker['email']) ?></p>

    <?php if (!empty($gebruiker['avatar_url'])): ?>
        <img src=".<?= htmlspecialchars($gebruiker['avatar_url']) ?>" alt="Profielfoto" width="150">
    <?php else: ?>
        <img src="../default-avatar.png" alt="Geen profielfoto" width="150">
    <?php endif; ?>

    <p><strong>Bio:</strong><br> <?= nl2br(htmlspecialchars($gebruiker['bio'])) ?></p>

    <a href="./logout.php">Uitloggen</a>
</body>
</html>
