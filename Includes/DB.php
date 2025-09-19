<?php
/**
 * DB.php
 *
 * Auteur: Milan
 * Beschrijving: Maakt een connectie met de MySQL database.
 */

// Database configuratie
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "intertoysoms_db";

// Maak connectie met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer of de connectie is gelukt
if ($conn->connect_error) {
    // Foutmelding naar console
    echo "<script>console.error('Connectie gefaald: " . addslashes($conn->connect_error) . "');</script>";
    exit();
}

// Succesmelding naar console
echo "<script>console.log('Database succesvol geconnect!');</script>";
?>
