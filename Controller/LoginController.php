<?php
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Includes/session.php';

// Check of het formulier verzonden is
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Haal e-mail en wachtwoord op uit het POST-verzoek
    $email = $_POST['email'];
    $wachtwoord = $_POST['password'];

    // Check of de 'Remember me' checkbox is aangevinkt
    $remember = isset($_POST['remember']);

    // Maak een nieuw User object aan
    $userModel = new User();

    // Probeer in te loggen met het opgegeven e-mailadres en wachtwoord
    $user = $userModel->login($email, $wachtwoord);

    // Als de login succesvol is
    if ($user){
        // Sla de gebruiker op in de session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['rol'] = $user['rol'];

        // Als 'Remember me' aangevinkt is, zet een cookie die 30 dagen geldig is
        if ($remember === true) {
            setcookie('user_id', $user['user_id'], time() + (86400 * 30), "/");
        }

        // Redirect naar een andere pagina, hier bijvoorbeeld het register formulier
        header("Location: ../view/dashboard.php");
        exit;
    } else {
        // Als e-mail of wachtwoord niet klopt, een foutmelding tonen
        header("Location: ../view/login.php?error=" . urlencode("Email of wachtwoord klopt niet!"));
        exit;
    }
}
