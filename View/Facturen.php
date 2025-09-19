<?php
/*
 * Facturen.php
 *
 * Auteur: Milan
 * Beschrijving: Beheert het overzicht van facturen. Laat facturen zien, toevoegen, bewerken en verwijderen.
 */

include('../Includes/DB.php');             // Database connectie
include('../Model/FacturenModel.php');     // Facturen model

session_start();

// Alleen Admin of Backofficemedewerker toegang
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['Admin', 'Backofficemedewerker'])) {
    echo "<script>alert('Geen toegang tot deze pagina!'); window.location.href='/View/Dashboard.php';</script>";
    exit;
}

$rol = $_SESSION['rol'];

// Haal alle facturen op
$facturen = FacturenModel::getAll($conn) ?? [];

// Haal orders op voor dropdown in form met berekend totaalbedrag
$ordersResult = $conn->query("
    SELECT o.order_id,
           CONCAT('Order ', o.order_id, ' - ', o.orderdatum, ' - ', o.status) AS label,
           IFNULL(SUM(op.aantal * p.prijs),0) AS totaal
    FROM `order` o
    LEFT JOIN order_product op ON o.order_id = op.order_id
    LEFT JOIN product p ON op.product_id = p.product_id
    GROUP BY o.order_id
    ORDER BY o.orderdatum DESC
");

// Zet orders in array
$orders = [];
if ($ordersResult && $ordersResult->num_rows > 0) {
    while ($o = $ordersResult->fetch_assoc()) {
        $orders[] = $o;
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturen</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../styles/leveranciers.css">
    <!-- JS voor popups -->
    <script src="../Javascript/FacturenPopup.js" defer></script>
</head>
<body>
<!-- Link naar dashboard en titel -->
<h1>
    <a href="/View/Dashboard.php" class="linkNaarDashboard">Intertoys OMS</a>
</h1>

<main>
    <h2>Facturen</h2>
    <button class="btn" id="openFormBtn">Factuur Toevoegen</button>

    <!-- Toevoegen popup -->
    <div id="factuurFormContainer" class="modal">
        <div class="modal-content">
            <span class="closeBtn">&times;</span>
            <h3>Nieuwe factuur toevoegen</h3>
            <form action="/Controller/FacturenController.php" method="post">
                <label>Order:</label>
                <select name="order_id" class="orderSelect" required>
                    <option value="">-- Kies een order --</option>
                    <?php foreach($orders as $o): ?>
                        <option value="<?= $o['order_id'] ?>" data-totaal="<?= $o['totaal'] ?>">
                            <?= htmlspecialchars($o['label']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Factuurdatum:</label>
                <input type="date" name="factuurdatum" required>

                <label>Totaalbedrag:</label>
                <input type="number" step="0.01" name="totaalbedrag" class="totaalInput" readonly required>

                <button type="submit" class="btn">Opslaan</button>
            </form>
        </div>
    </div>
</main>

<!-- Overzicht facturen -->
<div class="order-box">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Order ID</th>
                <th>Factuurdatum</th>
                <th>Totaalbedrag</th>
                <th>Orderdatum</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($facturen)): ?>
                <?php foreach ($facturen as $f): ?>
                    <tr>
                        <td><?= htmlspecialchars($f['factuur_id']) ?></td>
                        <td><?= htmlspecialchars($f['order_id']) ?></td>
                        <td><?= htmlspecialchars($f['factuurdatum']) ?></td>
                        <td><?= htmlspecialchars($f['totaalbedrag']) ?></td>
                        <td><?= htmlspecialchars($f['orderdatum']) ?></td>
                        <td><?= htmlspecialchars($f['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Geen facturen gevonden</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bewerken / Verwijderen popup -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="closeBtn">&times;</span>
        <h3>Factuur bewerken</h3>
        <form id="editForm" method="post">
            <!-- Hidden veld voor factuur_id -->
            <input type="hidden" name="factuur_id" id="edit_id">

            <label>Order:</label>
            <select name="order_id" id="edit_orderSelect" required>
                <option value="">-- Kies een order --</option>
                <?php foreach($orders as $o): ?>
                    <option value="<?= $o['order_id'] ?>" data-totaal="<?= $o['totaal'] ?>">
                        <?= htmlspecialchars($o['label']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Factuurdatum:</label>
            <input type="date" name="factuurdatum" id="edit_factuurdatum" required>

            <label>Totaalbedrag:</label>
            <input type="number" step="0.01" name="totaalbedrag" id="edit_totaalbedrag" readonly required>

            <button type="submit" class="btn" id="saveBtn">Opslaan</button>
            <button type="button" class="btn" id="deleteBtn">Verwijderen</button>
        </form>
    </div>
</div>
</body>
</html>
