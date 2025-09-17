<?php
require_once __DIR__ . '/../Includes/Session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Custom icon -->
    <link rel="icon" type="image/x-icon" href="../Content/logo.ico">
    <!-- Titel van de website -->
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/Dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Welkom op het Dashboard</h1>
        <div class="dashboard-buttons">
            <a href="../View/" class="dashboard-btn">Product</a>
            <a href="../View/Leveranciers.php" class="dashboard-btn">Leveranciers</a>
            <a href="../View/Facturen.php" class="dashboard-btn">Facturen</a>
            <a href="../View/Orders.php" class="dashboard-btn">Orders</a>
        </div>
        <a href="../View/Logout.php" class="logout-link">Uitloggen</a>
    </div>
</body>
</html>