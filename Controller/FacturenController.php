<?php
include_once("../Includes/DB.php");
include_once("../Model/FacturenModel.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_GET['action'] ?? '';

    $data = [
        'factuur_id' => $_POST['factuur_id'] ?? null,
        'order_id' => $_POST['order_id'] ?? null,
        'factuurdatum' => $_POST['factuurdatum'] ?? null,
        'totaalbedrag' => $_POST['totaalbedrag'] ?? null
    ];

    if ($action === 'update') {
        FacturenModel::update($conn, $data);
    } elseif ($action === 'delete') {
        FacturenModel::delete($conn, $data['factuur_id']);
    } else {
        FacturenModel::add($conn, $data);
    }

    header("Location: ../View/Facturen.php");
    exit;
}
?>
