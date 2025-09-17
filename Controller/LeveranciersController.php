<?php
include_once("../Includes/DB.php");
include_once("../Model/LeveranciersModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    $data = [
        'leverancier_id' => $_POST['leverancier_id'] ?? null,
        'bedrijfsnaam' => $_POST['bedrijfsnaam'] ?? null,
        'adres' => $_POST['adres'] ?? null,
        'contactpersoon' => $_POST['contactpersoon'] ?? null,
        'email' => $_POST['email'] ?? null
    ];

    if ($action === 'update') {
        LeveranciersModel::update($conn, $data);
    } elseif ($action === 'delete') {
        LeveranciersModel::delete($conn, $data['leverancier_id']);
    } else {
        LeveranciersModel::add($conn, $data);
    }

    header("Location: /View/Leveranciers.php");
    exit;
}

