<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        die("❌ Vul alle velden in!");
    }

    // Simpele mailfunctie (werkt alleen als mailserver is ingesteld)
    $to = "gtillemanns@gmail.com";
    $subject = "Nieuw Contactbericht van $name";
    $headers = "From: $email";

    if (mail($to, $subject, $message, $headers)) {
        echo "✅ Bericht verzonden!";
    } else {
        echo "❌ Fout bij verzenden!";
    }
}
?>
