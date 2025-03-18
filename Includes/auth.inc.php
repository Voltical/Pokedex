<?php
// Start de sessie (indien nog niet gestart)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check of gebruiker ingelogd is
if (!isset($_SESSION['user_id'])) {
    // Niet ingelogd? Stuur terug naar login pagina
    header('Location: ../pages/login.php');
    exit;
}
?>
