<?php
/**
 * FacturenController.php
 *
 * Auteur: Milan
 * Beschrijving: Controller voor het afhandelen van CRUD-acties (Create, Read, Update, Delete) rondom facturen.
 */

include_once("../Includes/DB.php");       // Databaseverbinding
include_once("../Model/FacturenModel.php"); // Facturen Model met databasefuncties

// Controleer of er een POST request is gedaan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Bepaal welke actie uitgevoerd moet worden (add, update, delete)
    $action = $_GET['action'] ?? '';

    // Verzamel de data uit het formulier (beveiligd met null coalescing)
    $data = [
        'factuur_id'   => $_POST['factuur_id'] ?? null,
        'order_id'     => $_POST['order_id'] ?? null,
        'factuurdatum' => $_POST['factuurdatum'] ?? null,
        'totaalbedrag' => $_POST['totaalbedrag'] ?? null
    ];

    // Kies de juiste actie
    if ($action === 'update') {
        // Update bestaande factuur
        FacturenModel::update($conn, $data);

    } elseif ($action === 'delete') {
        // Verwijder factuur op basis van ID
        FacturenModel::delete($conn, $data['factuur_id']);

    } else {
        // Voeg een nieuwe factuur toe
        FacturenModel::add($conn, $data);
    }

    // Na de actie terugsturen naar de facturenpagina
    header("Location: ../View/Facturen.php");
    exit;
}
?>
