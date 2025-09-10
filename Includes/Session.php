<?php
// Start een nieuwe session of hervat een bestaande
session_start();

require_once __DIR__ . '/DB.php'; // Zorg dat $conn beschikbaar is

// Check of de gebruiker **nog niet** ingelogd is via session
// maar wel een 'remember me' cookie aanwezig is
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $userId = $_COOKIE['user_id'];
    
    // Gebruik de juiste tabelnaam
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $userId); 
    $stmt->execute();              
    $result = $stmt->get_result();

    // Controleer of er precies één gebruiker is gevonden
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Zet de gebruiker in de session zodat hij/zij ingelogd is
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['rol']     = $user['rol'];
    }
}
