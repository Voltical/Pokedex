<?php
session_start();
require_once '../Includes/database.inc.php';
use Includes\Database;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_SESSION['user_id'])) {
        die("❌ Je moet ingelogd zijn om je profiel te bewerken.");
    }

    $userId = $_SESSION['user_id'];
    $newUsername = isset($_POST['new_username']) ? trim($_POST['new_username']) : '';
    $newEmail = isset($_POST['new_email']) ? trim($_POST['new_email']) : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // ✅ Zorg dat de uploads-map bestaat
    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // ✅ Profielfoto uploaden als er een bestand is gekozen
    if (!empty($_FILES['avatar']['name'])) {
        $fileName = time() . "_" . basename($_FILES["avatar"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $validExtensions)) {
            $_SESSION['message'] = "❌ Alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan.";
            header("Location: ../index.php?account=1");
            exit;
        }

        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFilePath)) {
            $avatarUrl = "./uploads/" . $fileName; // Correct bestandspad
            Database::executeQuery("UPDATE users SET avatar = ? WHERE id = ?", [$avatarUrl, $userId]);
            $_SESSION['avatar'] = $avatarUrl;
            $_SESSION['message'] = "✅ Profielfoto succesvol bijgewerkt!";
        }
    }

    // ✅ Gebruikersnaam updaten ALS er iets is ingevuld
    if (!empty($newUsername)) {
        Database::executeQuery("UPDATE users SET username = ? WHERE id = ?", [$newUsername, $userId]);
        $_SESSION['username'] = $newUsername;
        $_SESSION['message'] = "✅ Gebruikersnaam succesvol gewijzigd!";
    }

    // ✅ E-mail updaten ALS er iets is ingevuld
    if (!empty($newEmail)) {
        // Controleer of het e-mailadres al in gebruik is
        $checkEmail = Database::getData("SELECT id FROM users WHERE email = ?", [$newEmail]);
        if (!empty($checkEmail)) {
            $_SESSION['message'] = "❌ Dit e-mailadres is al in gebruik!";
            header("Location: ../index.php?account=1");
            exit;
        }

        Database::executeQuery("UPDATE users SET email = ? WHERE id = ?", [$newEmail, $userId]);
        $_SESSION['email'] = $newEmail;
        $_SESSION['message'] = "✅ E-mailadres succesvol gewijzigd!";
    }

    // ✅ Wachtwoord updaten ALS er iets is ingevuld
    if (!empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword !== $confirmPassword) {
            $_SESSION['message'] = "❌ Wachtwoorden komen niet overeen!";
            header("Location: ../index.php?account=1");
            exit;
        }

        // ✅ Hash het wachtwoord voor veiligheid
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        Database::executeQuery("UPDATE users SET password = ? WHERE id = ?", [$hashedPassword, $userId]);

        $_SESSION['message'] = "✅ Wachtwoord succesvol gewijzigd!";
    }

    // ✅ Redirect naar accountpagina
    header("Location: ../index.php?account=1");
    exit;
}
?>
