<?php
/*
 * Dashboard.php
 *
 * Auteur: Milan
 * Beschrijving: Dashboard pagina voor ingelogde gebruikers.
 */

require_once '../Includes/Session.php'; // Start of hervat de sessie

// Check of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php"); // Redirect naar login als niet ingelogd
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../Content/logo.ico">
    <title>Dashboard</title>
    <!-- CSS voor het dashboard -->
    <link rel="stylesheet" href="../styles/Dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Welkomsttekst -->
        <h1>Welkom op het Dashboard</h1>

        <!-- Navigatieknoppen naar verschillende modules -->
        <div class="dashboard-buttons">
            <a href="../View/Producten.php" class="dashboard-btn">Product</a>
            <a href="../View/Leveranciers.php" class="dashboard-btn">Leveranciers</a>
            <a href="../View/Facturen.php" class="dashboard-btn">Facturen</a>
            <a href="../View/Orders.php" class="dashboard-btn">Orders</a>
            <a href="../View/Klanten.php" class="dashboard-btn">Users</a>
        </div>

        <!-- Link om uit te loggen -->
        <a href="../View/Logout.php" class="logout-link">Uitloggen</a>
    </div>
</body>
</html>
