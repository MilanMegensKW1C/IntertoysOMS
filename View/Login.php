<?php
    include('../Includes/DB.php');
    $error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom icon -->
    <link rel="icon" type="image/x-icon" href="../Content/logo.ico">
    <!-- Link voor css sheet -->
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
        <?php if ($error): ?>
            <div class="error-message" style="color:red; margin-bottom:10px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
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

            <!-- Extra opties onder wachtwoord -->
            <div class="extra">
                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Onthouden</label>
                </div>
            </div>

            <!-- Inlog knop -->
            <input type="submit" value="Log in">

            <!-- Account aanmaken -->
            <div class="account-link">
                <a href="register.php">Maak een account aan</a>
            </div>
        </form>
    </div>
</body>
</html>