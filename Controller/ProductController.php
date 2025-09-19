<?php
include(__DIR__ . '/../Includes/DB.php');
include(__DIR__ . '/../Model/ProductModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $product_id = $_POST['product_id'] ?? null;

        if ($action === 'delete' && $product_id) {
            deleteProduct($conn, $product_id);

        } elseif ($action === 'update' && $product_id) {
            $naam = $_POST['naam'];
            $omschrijving = $_POST['omschrijving'];
            $prijs = $_POST['prijs'];
            $voorraad = $_POST['voorraad'];
            $leverancier_id = $_POST['leverancier_id'];
            updateProduct($conn, $product_id, $naam, $omschrijving, $prijs, $voorraad, $leverancier_id);

        } elseif ($action === 'add') {
            $naam = $_POST['naam'];
            $omschrijving = $_POST['omschrijving'];
            $prijs = $_POST['prijs'];
            $voorraad = $_POST['voorraad'];
            $leverancier_id = $_POST['leverancier_id'];
            addProduct($conn, $naam, $omschrijving, $prijs, $voorraad, $leverancier_id);
        }
    }
}

header("Location: ../View/Producten.php");
exit;
