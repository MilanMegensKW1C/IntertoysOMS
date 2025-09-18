<?php
/**
 * User
 *
 * Auteur: Milan
 * Beschrijving: Bevat functies voor gebruikersregistratie en login.
 */
require_once '../Includes/DB.php'; // Database connectie

class User { 
    private $conn;

    // Constructor: koppelt de globale database connectie aan dit object
    public function __construct() {
        global $conn; 
        $this->conn = $conn;
    }

    public function register($voornaam, $achternaam, $adres, $email, $wachtwoord){
        // Hash het wachtwoord voor veiligheid
        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        // Standaard rol voor nieuwe gebruikers
        $rol = 'klant';

        // Bereid SQL statement voor
        $stmt = $this->conn->prepare(
            "INSERT INTO user (wachtwoord, rol, voornaam, achternaam, adres, email) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        // Bind waarden aan statement
        $stmt->bind_param("ssssss", $hashedPassword, $rol, $voornaam, $achternaam, $adres, $email);

        // Voer uit
        return $stmt->execute();
    }

    // Login gebruiker met email en wachtwoord
    public function login($email, $wachtwoord){
        // Bereid SQL statement voor
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();             
        $result = $stmt->get_result(); 

        // Check of exact één gebruiker gevonden is
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Vergelijk wachtwoord met gehashte versie
            if (password_verify($wachtwoord, $user['wachtwoord'])) {
                return $user;
            }
        }

        // Geen match = false teruggeven
        return false;
    }
}
?>
