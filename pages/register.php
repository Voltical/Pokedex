<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$root = "../";
require_once($root . "Includes/config.inc.php");

//session_start();
//require_once '../Includes/database.inc.php';
use Includes\Database;

$response = ['success' => false, 'message' => ''];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Ongeldige aanvraag.");
    }

    // Haal de form data op
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $passwordConfirm = isset($_POST['password_confirm']) ? trim($_POST['password_confirm']) : '';

    // Basis validaties
    if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) {
        throw new Exception("Vul alle velden in.");
    }
    if ($password !== $passwordConfirm) {
        throw new Exception("De wachtwoorden komen niet overeen.");
    }

    // Controleer of de gebruikersnaam of e-mail al bestaat
    $sql = "SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1";
    $bestaande_gebruiker = Database::getData($sql, [$username, $email]);

    if (!empty($bestaande_gebruiker)) {
        throw new Exception("Gebruikersnaam of e-mail is al in gebruik.");
    }

    // Wachtwoord hash en gebruiker invoegen
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    Database::executeQuery($sql, [$username, $email, $password_hash]);
    

    // Haal de ID op van de nieuw aangemaakte gebruiker
    $user = Database::getData("SELECT id FROM users WHERE email = ? LIMIT 1", [$email]);
    //$user = Database::getLastInsertedRow();

    if (empty($user)) {
        throw new Exception("Fout bij het ophalen van gebruikersgegevens.");
    }

    $_SESSION['user_id'] = $user[0]['id'];
    $_SESSION['username'] = $username;

    $response['success'] = true;
    $response['message'] = "Account succesvol aangemaakt!";
} catch (Exception $e) {
    $response['message'] = "Fout: " . $e->getMessage();
}

// Verwijder alle output vóór de JSON-response
if (ob_get_contents()) {
    ob_clean();
}

echo json_encode($response);
exit();
