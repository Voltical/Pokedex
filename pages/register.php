<?php
session_start();
require_once '../Includes/database.inc.php'; // Jouw database class
use Includes\Database; // Correcte namespace

$foutmelding = '';
$succesmelding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Check of velden ingevuld zijn
    if ($username === '' || $email === '' || $password === '') {
        $foutmelding = "Vul alle velden in.";
    } else {
        // Check of gebruikersnaam of email al bestaat
        $sql = "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1";
        $bestaande_gebruiker = Database::getData($sql, [$username, $email]);

        if (count($bestaande_gebruiker) > 0) {
            $foutmelding = "Gebruikersnaam of e-mail is al in gebruik.";
        } else {
            // Wachtwoord hashen
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insert query
            $sql_insert = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
            Database::insertData($sql_insert, [$username, $email, $password_hash]);

            $succesmelding = "Account succesvol aangemaakt. Je kunt nu <a href='./login.php'>inloggen</a>!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="shortcut icon" href="../assets/favicon.png" type="image/x-icon">
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        form { max-width: 400px; margin: auto; }
        input { display: block; width: 100%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px; width: 100%; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h2>Account aanmaken</h2>

    <?php if (!empty($foutmelding)): ?>
        <p class="error"><?= htmlspecialchars($foutmelding) ?></p>
    <?php endif; ?>

    <?php if (!empty($succesmelding)): ?>
        <p class="success"><?= $succesmelding ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="email" name="email" placeholder="E-mailadres" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Registreren</button>
    </form>
</body>
</html>
