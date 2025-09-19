<?php
// Orders ophalen
function getOrders($conn) {
    $sql = "
        SELECT 
            o.order_id,
            o.orderdatum,
            o.status,
            CONCAT(u.voornaam, ' ', u.achternaam) AS klantnaam,
            p.naam AS productnaam,
            op.aantal
        FROM `Order` o
        JOIN User u ON o.user_id = u.user_id
        JOIN order_product op ON o.order_id = op.order_id
        JOIN product p ON op.product_id = p.product_id
        ORDER BY o.orderdatum DESC
    ";

    $result = $conn->query($sql);
    $orders = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $orderId = $row['order_id'];
            if (!isset($orders[$orderId])) {
                $orders[$orderId] = [
                    'order_id' => $row['order_id'],
                    'orderdatum' => $row['orderdatum'],
                    'status' => $row['status'],
                    'klantnaam' => $row['klantnaam'],
                    'producten' => []
                ];
            }
            $orders[$orderId]['producten'][] = [
                'naam' => $row['productnaam'],
                'aantal' => $row['aantal']
            ];
        }
    }
    return $orders;
}

// Users ophalen
function getUsers($conn) {
    $users = [];
    $res = $conn->query("SELECT user_id, voornaam, achternaam FROM User");
    if ($res && $res->num_rows > 0) {
        while ($u = $res->fetch_assoc()) {
            $users[] = $u;
        }
    }
    return $users;
}

// Producten ophalen
function getProducten($conn) {
    $producten = [];
    $res = $conn->query("SELECT product_id, naam FROM product");
    if ($res && $res->num_rows > 0) {
        while ($p = $res->fetch_assoc()) {
            $producten[] = $p;
        }
    }
    return $producten;
}

// Order updaten
function updateOrder($conn, $order_id, $user_id, $datum, $status) {
    $stmt = $conn->prepare("UPDATE `Order` SET user_id=?, orderdatum=?, status=? WHERE order_id=?");
    $stmt->bind_param("issi", $user_id, $datum, $status, $order_id);
    $stmt->execute();
    $stmt->close();
}

// Order verwijderen
function deleteOrder($conn, $order_id) {
    $stmt = $conn->prepare("DELETE FROM order_product WHERE order_id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM `Order` WHERE order_id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();
}
