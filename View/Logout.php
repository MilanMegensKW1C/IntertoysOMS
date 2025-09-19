<?php
/*
 * Logout.php
 *
 * Auteur: Milan
 * Beschrijving: Logt de gebruiker uit door de sessie te vernietigen en de 'remember me' cookie te verwijderen.
 */

session_start(); // Start de sessie om deze te kunnen vernietigen

// Verwijder alle sessie-variabelen
$_SESSION = array();

// Vernietig de sessie volledig
session_destroy();

// Verwijder de 'remember me' cookie
setcookie('user_id', '', time() - 3600, '/');

// Redirect naar de loginpagina
header("Location: Login.php");
exit;
?>
