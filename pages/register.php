<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST["gebruikersnaam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $wachtwoord_confirm = $_POST["wachtwoord_confirm"];

    if ($wachtwoord !== $wachtwoord_confirm) {
        $_SESSION["register_error"] = "Wachtwoorden komen niet overeen!";
        header("Location: ../index.php?modal=register");
        exit();
    }

    // Simuleer succesvolle registratie
    $_SESSION["register_success"] = "Registratie geslaagd! Je kunt nu inloggen.";
    header("Location: ../index.php?modal=login");
    exit();
}
?>
