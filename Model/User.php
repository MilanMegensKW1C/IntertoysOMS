<?php
require_once __DIR__ . '/../Includes/DB.php';

class User { 
    private $conn;

    // Constructor wordt aangeroepen bij het aanmaken van een User-object
    public function __construct() {
        global $conn; 
        $this->conn = $conn;
    }

    // Functie om een nieuwe gebruiker te registreren
    public function register($voornaam, $achternaam, $adres, $email, $wachtwoord){
        // Wachtwoord hashen voor veiligheid
        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        // Standaard rol instellen voor nieuwe gebruikers
        $rol = 'klant';

        // SQL query voorbereiden met placeholders om SQL-injectie te voorkomen
        $stmt = $this->conn->prepare(
            "INSERT INTO user (wachtwoord, rol, voornaam, achternaam, adres, email) VALUES (?, ?, ?, ?, ?, ?)"
        );

        // De waarden binden aan de placeholders in de query
        $stmt->bind_param("ssssss", $hashedPassword, $rol, $voornaam, $achternaam, $adres, $email);

        // Query uitvoeren en true/false teruggeven afhankelijk van succes
        return $stmt->execute();
    }

    // Functie om een gebruiker in te laten loggen
    public function login($email, $wachtwoord){
        // SQL query voorbereiden om gebruiker met dit e-mailadres op te halen
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();             
        $result = $stmt->get_result(); 

        // Checken of er exact één gebruiker is gevonden
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Wachtwoord vergelijken met gehashte versie in DB
            if (password_verify($wachtwoord, $user['wachtwoord'])) {
                return $user;
            }
        }

        // Als geen gebruiker is gevonden of wachtwoord niet klopt, false teruggeven
        return false;
    }
}
