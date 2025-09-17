<?php
include('../Includes/DB.php');

// Orders ophalen
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

        // Zorg dat order slechts 1x bestaat
        if (!isset($orders[$orderId])) {
            $orders[$orderId] = [
                'order_id' => $row['order_id'],
                'orderdatum' => $row['orderdatum'],
                'status' => $row['status'],
                'klantnaam' => $row['klantnaam'],
                'producten' => ['']
            ];
        }

        // Voeg product toe
        $orders[$orderId]['producten'][] = [
            'naam' => $row['productnaam'],
            'aantal' => $row['aantal']
        ];
    }
}


// Users ophalen (voor dropdown in formulier)
$users = [];
$resUsers = $conn->query("SELECT user_id, voornaam, achternaam FROM User");
if ($resUsers && $resUsers->num_rows > 0) {
    while ($u = $resUsers->fetch_assoc()) {
        $users[] = $u;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
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
    <button class="btn" id="openFormBtn">Order Toevoegen</button>

<!-- Verborgen formulier -->
<div id="orderFormContainer" style="display: none; margin-top: 20px;">
    <form action="../Controller/add_order.php" method="post">
        <label for="user_id">Klant:</label>
        <select id="user_id" name="user_id" required>
            <option value="">-- Kies een klant --</option>
            <?php foreach ($users as $u): ?>
                <option value="<?= $u['user_id'] ?>">
                    <?= htmlspecialchars($u['voornaam'] . ' ' . $u['achternaam']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="datum">Orderdatum:</label>
        <input type="date" id="datum" name="datum" required>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="In behandeling">In behandeling</option>
            <option value="Verzonden">Verzonden</option>
            <option value="Afgerond">Afgerond</option>
        </select>

        <h4>Producten</h4>
        <div id="productenContainer">
            <div class="product-row">
                <select name="producten[0][id]" required>
                    <option value="">-- Kies een product --</option>
                    <?php foreach ($producten as $p): ?>
                        <option value="<?= $p['product_id'] ?>">
                            <?= htmlspecialchars($p['naam']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="producten[0][aantal]" min="1" value="1" required>
            </div>
        </div>

        <button type="button" id="addProductRow" class="btn">+ Product toevoegen</button>
        <br><br>
        <button type="submit" class="btn">Opslaan</button>
    </form>
</div>


</main>

<!-- Orders tabel -->
<div class="order-box">
    <table>
        <thead>
            <tr>
                <th>Order Id</th>
                <th>Orderdatum</th>
                <th>Klantnaam</th>
                <th>Status</th>
                <th>Producten</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($orders as $o): ?>
    <tr>
        <td><?= htmlspecialchars($o['order_id']) ?></td>
        <td><?= htmlspecialchars($o['orderdatum']) ?></td>
        <td><?= htmlspecialchars($o['klantnaam']) ?></td>
        <td><?= htmlspecialchars($o['status']) ?></td>
        <td>
            <ul>
                <?php foreach ($o['producten'] as $p): ?>
                    <li><?= htmlspecialchars($p['naam']) ?> (<?= htmlspecialchars($p['aantal']) ?>x)</li>
                <?php endforeach; ?>
            </ul>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>

    </table>
</div>

<script src="/IntertoysOMS/Javascript/OrderPopUp.js"></script>
</body>
</html>
