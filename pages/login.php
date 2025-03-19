<?php
session_start();
require_once '../Includes/database.inc.php'; // Jouw database klasse inladen

use Includes\Database; // Zorg dat de namespace klopt

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam_email = trim($_POST['gebruikersnaam_email'] ?? '');
    $wachtwoord = trim($_POST['wachtwoord'] ?? '');

    if ($gebruikersnaam_email !== '' && $wachtwoord !== '') {
        // Zoek gebruiker op username of e-mail
        $sql = "SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1";
        $gebruiker = Database::getData($sql, [$gebruikersnaam_email, $gebruikersnaam_email]);

        if (!empty($gebruiker) && password_verify($wachtwoord, $gebruiker[0]['password_hash'])) {
            // Gebruiker ingelogd, sla gegevens op in de sessie
            $_SESSION['user_id'] = $gebruiker[0]['id'];
            $_SESSION['username'] = $gebruiker[0]['username'];

            // Redirect naar dashboard of homepagina
            header('Location: ../index.php');
            exit;
        } else {
            $_SESSION['login_error'] = "Ongeldige gebruikersnaam/e-mail of wachtwoord!";
        }
    } else {
        $_SESSION['login_error'] = "Vul alle velden in!";
    }

    // Redirect terug naar login-modal in index.php
    header('Location: ../index.php?modal=login');
    exit;
}
?>
