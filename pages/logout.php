<?php
session_start(); // Start sessie

// Sessie leegmaken
$_SESSION = [];

// Sessie vernietigen
session_destroy();

// Terugsturen naar login pagina
header('Location: ../index.php');
exit;
?>
