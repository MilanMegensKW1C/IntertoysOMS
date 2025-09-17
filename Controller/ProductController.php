<?php
include('../Includes/DB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Formulierdata ophalen
    $naam = $_POST['naam'];
    $omschrijving = $_POST['omschrijving'];
    $prijs = $_POST['prijs'];
    $voorraad = $_POST['voorraad'];
    $leverancier_id = $_POST['leverancier_id'];

    // Product invoegen
    $stmt = $conn->prepare("
        INSERT INTO product (naam, omschrijving, prijs, voorraad, leverancier_id) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssdii", $naam, $omschrijving, $prijs, $voorraad, $leverancier_id);
    $stmt->execute();
    $stmt->close();

    // Redirect terug naar productenpagina
    header("Location: ../View/Producten.php");
    exit;
}
?>
