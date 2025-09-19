<?php
include('../Includes/DB.php');
include('../Model/OrdersModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $order_id = $_POST['order_id'] ?? 0;

    if ($action === 'delete') {
        // Verwijder order
        deleteOrder($conn, $order_id);

    } elseif ($action === 'update') {
        // Update ordergegevens
        $user_id = $_POST['user_id'];
        $datum = $_POST['datum'];
        $status = $_POST['status'];
        updateOrder($conn, $order_id, $user_id, $datum, $status);

    } elseif ($action === 'add') {
        // Voeg nieuwe order toe
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
    }
}

// Redirect terug naar orders pagina
header("Location: ../View/Orders.php");
exit;
?>
