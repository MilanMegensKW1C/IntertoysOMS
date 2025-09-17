<?php
include('../Includes/DB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $datum = $_POST['datum'];
    $status = $_POST['status'];
    $producten = $_POST['producten'];

    // Order invoegen
    $stmt = $conn->prepare("INSERT INTO `Order` (user_id, orderdatum, status) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $datum, $status);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Producten toevoegen
    $stmt = $conn->prepare("INSERT INTO order_product (order_id, product_id, aantal) VALUES (?, ?, ?)");
    foreach ($producten as $prod) {
        $stmt->bind_param("iii", $order_id, $prod['id'], $prod['aantal']);
        $stmt->execute();
    }
    $stmt->close();

    // Redirect terug naar orders
    header("Location: ../View/orders.php");
    exit;
}
