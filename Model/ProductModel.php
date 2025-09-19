<?php
// ProductModel.php

function getProducten($conn) {
    $producten = [];
    $sql = "
        SELECT 
            p.product_id,
            p.naam,
            p.omschrijving,
            p.prijs,
            p.voorraad,
            l.bedrijfsnaam AS leverancier
        FROM product p
        LEFT JOIN leverancier l ON p.leverancier_id = l.leverancier_id
        ORDER BY p.naam ASC
    ";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $producten[] = $row;
        }
    }
    return $producten;
}

function getLeveranciers($conn) {
    $leveranciers = [];
    $resLev = $conn->query("SELECT leverancier_id, bedrijfsnaam FROM leverancier");
    if ($resLev && $resLev->num_rows > 0) {
        while ($l = $resLev->fetch_assoc()) {
            $leveranciers[] = $l;
        }
    }
    return $leveranciers;
}

function addProduct($conn, $naam, $omschrijving, $prijs, $voorraad, $leverancier_id) {
    $stmt = $conn->prepare("
        INSERT INTO product (naam, omschrijving, prijs, voorraad, leverancier_id)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssdii", $naam, $omschrijving, $prijs, $voorraad, $leverancier_id);
    $stmt->execute();
    $stmt->close();
}

function updateProduct($conn, $product_id, $naam, $omschrijving, $prijs, $voorraad, $leverancier_id) {
    $stmt = $conn->prepare("
        UPDATE product SET naam=?, omschrijving=?, prijs=?, voorraad=?, leverancier_id=? 
        WHERE product_id=?
    ");
    $stmt->bind_param("ssdiii", $naam, $omschrijving, $prijs, $voorraad, $leverancier_id, $product_id);
    $stmt->execute();
    $stmt->close();
}

function deleteProduct($conn, $product_id) {
    $stmt = $conn->prepare("DELETE FROM product WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->close();
}
