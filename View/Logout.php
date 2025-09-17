<?php
session_start();

// Verwijder alle sessie-variabelen
$_SESSION = array();

// Vernietig de sessie
session_destroy();

// Verwijder de 'remember me' cookie
setcookie('user_id', '', time() - 3600, '/');

// Stuur door naar de loginpagina
header("Location: Login.php");
exit;