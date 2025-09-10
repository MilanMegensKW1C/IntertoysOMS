<?php
require_once __DIR__ . '/../Model/User.php';

class RegisterController {

    // Functie om de registratiepagina te tonen
    public function index() {
        include __DIR__ . '/../View/Register.php';
    }

    // Functie om een nieuwe gebruiker op te slaan in de database
    public function store(){
        // Check of het formulier via POST is verzonden
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Haal de gegevens op uit het formulier
            $voornaam   = $_POST['firstname'];
            $achternaam = $_POST['lastname'];
            $adres      = $_POST['address'];
            $email      = $_POST['email'];
            $wachtwoord = $_POST['password'];
        }

        // Maak een nieuw User object aan (het model)
        $user = new User();
        
        // Probeer de gebruiker te registreren
        if ($user->register($voornaam, $achternaam, $adres, $email, $wachtwoord)) {
            // Als registratie succesvol is, doorsturen naar login pagina
            header("Location: login.php");
            exit;
        } else {
            // Als registratie mislukt, een foutmelding tonen
            echo "Er ging iets mis bij het registreren!";
        }
    }
}
