<?php
/*
 * Login.php
 *
 * Auteur: Milan
 * Beschrijving: Inlogpagina voor gebruikers. Laat gebruikers inloggen met email en wachtwoord.
 */

include('../Includes/DB.php'); // Database connectie

// Check of er een error is
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../Content/logo.ico">
    <!-- Link naar CSS -->
    <link rel="stylesheet" href="../styles/Login.css">
    <title>Inloggen</title>
</head>
<body class="loginpagina">

    <!-- Titel van de pagina -->
    <div class="titel">
        <h1>Intertoys<br>OMS</h1>
    </div>
    
    <!-- Inlogformulier -->
    <div class="form">
        <h1>Login</h1>

        <!-- Foutmelding tonen indien aanwezig -->
        <?php if ($error): ?>
            <div class="error-message" style="color:red; margin-bottom:10px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Formulier voor login -->
        <form action="../Controller/LoginController.php" method="post">
            
            <!-- Email veld -->
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <!-- Wachtwoord veld -->
            <div class="input-group">
                <label for="password">Wachtwoord</label>
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Extra opties onder wachtwoord (bijv. onthouden) -->
            <div class="extra">
                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Onthouden</label>
                </div>
            </div>

            <!-- Inlog knop -->
            <input type="submit" value="Log in">

            <!-- Link om account aan te maken -->
            <div class="account-link">
                <a href="register.php">Maak een account aan</a>
            </div>
        </form>
    </div>
</body>
</html>
