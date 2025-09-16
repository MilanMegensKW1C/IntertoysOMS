<?php
include('../Includes/DB.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $datum = $_POST['datum'] ?? null;
    $status = $_POST['status'] ?? 'In behandeling';

    if ($user_id && $datum) {
        $stmt = $conn->prepare("INSERT INTO `Order` (user_id, orderdatum, status) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $datum, $status);
        $stmt->execute();
    }
}

// Terug naar overzicht
header("Location: ../View/orders.php");
exit;
