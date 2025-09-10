<?php

include('../Includes/DB.php');

$sql = "
    SELECT 
        o.order_id,
        o.orderdatum,
        o.status,
        CONCAT(k.voornaam, ' ', k.achternaam) AS klantnaam,
        SUM(p.prijs * op.aantal) AS totaalprijs
    FROM `Order` o
    JOIN Klant k ON o.klant_id = k.klant_id
    JOIN Order_Product op ON o.order_id = op.order_id
    JOIN Product p ON op.product_id = p.product_id
    GROUP BY o.order_id, o.orderdatum, o.status, klantnaam
    ORDER BY o.orderdatum DESC
";

$result = $conn->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="/IntertoysOMS/styles/Orders.css">
</head>
<body>
<h1>Intertoys OMS</h1>

<main>
    <h2>Orders</h2>
    <button class="btn" id="openModalBtn">Order Toevoegen</button>

</main>
    
 <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <h3>Nieuwe Order</h3>
            <form action="add_order.php" method="post">
                <label for="klant">Klantnaam:</label>
                <input type="text" id="klant" name="klant" required>

                <label for="datum">Orderdatum:</label>
                <input type="date" id="datum" name="datum" required>

                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="In behandeling">In behandeling</option>
                    <option value="Verzonden">Verzonden</option>
                    <option value="Afgerond">Afgerond</option>
                </select>

                <button type="submit" class="btn">Opslaan</button>
            </form>
        </div>
    </div>

 <div class="order-box">
            <table>
                <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Orderdatum</th>
                        <th>Klantnaam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $o): ?>
            <tr>
                <td><?= htmlspecialchars($o['order_id']) ?></td>
                <td><?= htmlspecialchars($o['orderdatum']) ?></td>
                <td><?= htmlspecialchars($o['klantnaam']) ?></td>
                <td><?= htmlspecialchars($o['status']) ?></td>
            </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <script src="/IntertoysOMS/View/OrderPopUp.js"></script>
</body>
</html>