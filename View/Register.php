<?php
/*
 * register.php
 *
 * Auteur: Milan
 * Beschrijving: Pagina voor het registreren van een nieuwe gebruiker. Roept de RegisterController aan bij POST-verzoeken.
 */

require_once '../Controller/RegisterController.php';

// Controller aanmaken
$controller = new RegisterController();

// Gebruik de 'store' functie in de controller
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../Content/logo.ico">
    <!-- Link naar CSS -->
    <link rel="stylesheet" href="../styles/Login.css">
    <title>Registreren</title>
</head>
<body class="loginpagina">
    <!-- Titel van de pagina -->
    <div class="titel">
        <h1>Intertoys<br>OMS</h1>
    </div>
    
    <!-- Registratieformulier -->
    <div class="form">
        <h1>Registreer</h1>
        <form action="register.php" method="post">
            <!-- Voornaam en Achternaam naast elkaar -->
            <div class="input-row">
                <div class="input-group">
                    <label for="firstname">Voornaam</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div class="input-group">
                    <label for="lastname">Achternaam</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
            </div>

            <!-- Adres -->
            <div class="input-group">
                <label for="address">Adres</label>
                <input type="text" id="address" name="address" required>
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <!-- Wachtwoord -->
            <div class="input-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Registreer knop -->
            <input type="submit" value="Registreer">

            <!-- Link naar inloggen -->
            <div class="account-link">
                <a href="login.php">Inloggen</a>
            </div>
        </form>
    </div>
</body>
</html>
