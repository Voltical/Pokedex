<?php
session_start();
require_once '../Includes/database.inc.php'; // Jouw class wordt ingeladen

use Includes\Database; // Gebruik de juiste namespace

$foutmelding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam_email = isset($_POST['gebruikersnaam_email']) ? trim($_POST['gebruikersnaam_email']) : '';
    $wachtwoord = isset($_POST['wachtwoord']) ? trim($_POST['wachtwoord']) : '';

    if ($gebruikersnaam_email !== '' && $wachtwoord !== '') {
        // Query met jouw getData functie
        $sql = "SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1";
        $gebruiker = Database::getData($sql, [$gebruikersnaam_email, $gebruikersnaam_email]);

        if (count($gebruiker) > 0 && password_verify($wachtwoord, $gebruiker[0]['password_hash'])) {
            $_SESSION['user_id'] = $gebruiker[0]['id'];
            $_SESSION['username'] = $gebruiker[0]['username'];
            header('Location: ../index.php'); // Succesvol ingelogd
            exit;
        } else {
            $foutmelding = "Ongeldige gebruikersnaam/e-mail of wachtwoord.";
        }
    } else {
        $foutmelding = "Vul alle velden in.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link rel="stylesheet" href="../style/login.css">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="hero">
        <div class="login-container">
            <h2>Inloggen</h2>
            <?php if (!empty($foutmelding)): ?>
                <p class="error"><?= htmlspecialchars($foutmelding) ?></p>
            <?php endif; ?>

            <form method="POST" action="">
                <input type="text" name="gebruikersnaam_email" placeholder="Gebruikersnaam of E-mail" required>
                <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
                <button type="submit">Inloggen</button>
            </form>
        </div>
    </div>
</body>
</html>