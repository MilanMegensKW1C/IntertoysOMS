<?php
/**
 * LoginController.php
 *
 * Auteur: Milan
 * Beschrijving: Controller voor het afhandelen van login-logica.
 */

require_once '../Model/User.php';       // User model voor login-functionaliteit
require_once '../Includes/session.php'; // Link met Session

// Controleer of het formulier verzonden is via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gegevens uit POST halen
    $email      = $_POST['email'];
    $wachtwoord = $_POST['password'];
    $remember   = isset($_POST['remember']);

    // Maak User-model aan en probeer in te loggen
    $userModel = new User();
    $user = $userModel->login($email, $wachtwoord);

    // Als inloggen lukt
    if ($user) {
        // Sla gegevens van de gebruiker op in de sessie
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['rol']     = $user['rol'];

        // Als "Remember me" aangevinkt is dan cookie zetten voor 30 dagen
        if ($remember === true) {
            setcookie('user_id', $user['user_id'], time() + (86400 * 30), "/");
        }

        // Doorsturen naar dashboard
        header("Location: ../view/dashboard.php");
        exit;
    } else {
        // Ongeldige login = terug naar loginpagina met foutmelding
        header("Location: ../view/login.php?error=" . urlencode("Email of wachtwoord klopt niet!"));
        exit;
    }
}
