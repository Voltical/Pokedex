<?php
session_start();
require_once '../Includes/database.inc.php';
use Includes\Database;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'];
    $newUsername = trim($_POST['new_username']);

    // ✅ Controleer of de uploads-map bestaat, zo niet, maak deze aan
    $uploadDir = __DIR__ . "./uploads/"; // Zorgt ervoor dat het absolute pad wordt gebruikt

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // ✅ Maakt de map aan met juiste rechten
    }

    // ✅ Profielfoto uploaden
    if (!empty($_FILES['avatar']['name'])) {
        $fileName = basename($_FILES["avatar"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // ✅ Controleer of het een geldige afbeelding is
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $validExtensions)) {
            die("❌ Alleen JPG, JPEG, PNG & GIF zijn toegestaan.");
        }

        // ✅ Upload bestand
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
            // ✅ Sla de URL op in de database
            $avatarUrl = "./pages/uploads/" . $fileName;
            Database::executeQuery("UPDATE users SET avatar = ? WHERE id = ?", [$avatarUrl, $userId]);
            $_SESSION['avatar'] = $avatarUrl; // ✅ Update de sessie
        } else {
            die("❌ Fout bij uploaden.");
        }
    }

    // ✅ Gebruikersnaam updaten
    Database::executeQuery("UPDATE users SET username = ? WHERE id = ?", [$newUsername, $userId]); // ❌ Gebruik executeQuery()
    $_SESSION['username'] = $newUsername;

    header("Location: ../index.php");
    exit;
}
?>
