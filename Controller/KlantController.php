<?php
include('../Includes/DB.php');
include('../Model/KlantModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = $_POST['user_id'] ?? null;

    if ($action === 'update') {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        updateUser($conn, $user_id, $voornaam, $achternaam, $email, $rol);
    } elseif ($action === 'delete') {
        deleteUser($conn, $user_id);
    } elseif ($action === 'add') {
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];
        addUser($conn, $voornaam, $achternaam, $email, $rol);
    }
}

header("Location: ../View/Klanten.php");
exit;
?>
