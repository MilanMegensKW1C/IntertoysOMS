<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="../styles/Login.css">
    <title>Registreren</title>
</head>
<body class="loginpagina">
    <!-- Titel van de pagina -->
    <div class="titel">
        <h1>Intertoys<br>OMS</h1>
    </div>
    
    <!-- Inlogformulier -->
    <div class="form">
        <h1>Registreer</h1>
        <form action="login.php" method="post">
            <!-- Voornaam en Achternaam op één regel -->
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

            <!-- Adres veld -->
            <div class="input-group">
                <label for="address">Adres</label>
                <input type="text" id="address" name="address" required>
            </div>

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

            <!-- Registreer knop -->
            <input type="submit" value="Registreer">

            <!-- Account aanmaken -->
            <div class="account-link">
                <a href="login.php">Inloggen</a>
            </div>
        </form>
    </div>
</body>
</html>