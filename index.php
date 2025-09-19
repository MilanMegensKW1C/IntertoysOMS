<?php
/*
 * index.php
 *
 * Auteur: Milan
 * Beschrijving: Startpagina die checkt of een gebruiker is ingelogd. Zo ja, redirect naar Dashboard, anders naar Login.
 */

require_once 'Includes/Session.php';

// Controleer of de gebruiker is ingelogd
if (isset($_SESSION['user_id'])) {
    // Gebruiker is ingelogd = doorsturen naar dashboard
    header("Location: view/Dashboard.php");
    exit;
} else {
    // Gebruiker is niet ingelogd = doorsturen naar login
    header("Location: view/Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aan het laden...</title>
</head>
<body>
</body>
</html>
