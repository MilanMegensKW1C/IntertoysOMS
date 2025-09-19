<?php
/**
 * RegisterController.php
 *
 * Auteur: Milan
 * Beschrijving: Controller voor het registreren van nieuwe gebruikers.
 */

require_once '../Model/User.php'; // User model voor registratie-functionaliteit

class RegisterController {

    /**
     * Toont de registratiepagina.
     */
    public function index() {
        include '../View/Register.php';
    }

    public function store() {
        // Check of het formulier via POST is verzonden
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Haal de gegevens op uit het formulier
            $voornaam   = $_POST['firstname'];
            $achternaam = $_POST['lastname'];
            $adres      = $_POST['address'];
            $email      = $_POST['email'];
            $wachtwoord = $_POST['password'];

            // Maak een nieuw User object aan
            $user = new User();

            // Probeer de gebruiker te registreren
            if ($user->register($voornaam, $achternaam, $adres, $email, $wachtwoord)) {
                // Als registratie succesvol is, doorsturen naar login pagina
                header("Location: login.php");
                exit;
            } else {
                // Als registratie mislukt, foutmelding tonen
                echo "Er ging iets mis bij het registreren!";
            }
        }
    }
}
