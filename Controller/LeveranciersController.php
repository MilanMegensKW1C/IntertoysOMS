<?php
/**
 * LeveranciersController.php
 *
 * Auteur: Milan
 * Beschrijving: Controller voor CRUD-acties (toevoegen, updaten, verwijderen) van leveranciers.
 */

include_once("../Includes/DB.php");            // Databaseverbinding
include_once("../Model/LeveranciersModel.php"); // Model met databasefuncties voor leveranciers

// Controleer of er een POST request is gedaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Haal de actie op uit de URL (add, update, delete)
    $action = $_GET['action'] ?? '';

    // Verzamel de formulierdata
    $data = [
        'leverancier_id' => $_POST['leverancier_id'] ?? null,
        'bedrijfsnaam'   => $_POST['bedrijfsnaam'] ?? null,
        'adres'          => $_POST['adres'] ?? null,
        'contactpersoon' => $_POST['contactpersoon'] ?? null,
        'email'          => $_POST['email'] ?? null
    ];

    // Verwerk de juiste actie
    if ($action === 'update') {
        LeveranciersModel::update($conn, $data);
    } elseif ($action === 'delete') {
        LeveranciersModel::delete($conn, $data['leverancier_id']);
    } else {
        LeveranciersModel::add($conn, $data);
    }

    // Redirect terug naar de leverancierspagina
    header("Location: /View/Leveranciers.php");
    exit;
}
?>
