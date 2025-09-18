<?php
/**
 * session.php
 *
 * Auteur: Milan
 * Beschrijving: Start of hervat een sessie en slaat rol op waarmee is ingelogd
 */

// Start session
session_start();

// Database connectie inladen
require_once 'DB.php';

// Controleer of er nog geen actieve sessie is, maar wél een cookie aanwezig is
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $userId = $_COOKIE['user_id'];

    // Haal de gebruiker op bij dit ID
    $stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
    $stmt->bind_param("i", $userId); 
    $stmt->execute();              
    $result = $stmt->get_result();

    // Als de gebruiker bestaat, zet data in de sessie
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['rol']     = $user['rol'];
    }
}

// Log de huidige rol naar de browser console (voor debuggen)
if (isset($_SESSION['rol'])) {
    echo "<script>console.log('Ingelogd als rol: " . $_SESSION['rol'] . "');</script>";
}
?>
