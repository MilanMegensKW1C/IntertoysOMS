<?php
include('../Includes/DB.php');

// Producten ophalen
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

$producten = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $producten[] = $row;
    }
}

// Leveranciers ophalen (voor dropdown in formulier)
$leveranciers = [];
$resLev = $conn->query("SELECT leverancier_id, bedrijfsnaam FROM leverancier");
if ($resLev && $resLev->num_rows > 0) {
    while ($l = $resLev->fetch_assoc()) {
        $leveranciers[] = $l;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>
    <link rel="stylesheet" href="/IntertoysOMS/styles/Orders.css">
</head>
<body>
<h1>Intertoys OMS</h1>

<main>
    <h2>Producten</h2>
    <button class="btn" id="openFormBtn">Product Toevoegen</button>

    <!-- Verborgen formulier -->
    <div id="orderFormContainer" style="display: none; margin-top: 20px;">
        <form action="../Controller/ProductController.php" method="post">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" required>

            <label for="omschrijving">Omschrijving:</label>
            <textarea id="omschrijving" name="omschrijving" required></textarea>

            <label for="prijs">Prijs (€):</label>
            <input type="number" id="prijs" name="prijs" step="0.01" required>

            <label for="voorraad">Voorraad:</label>
            <input type="number" id="voorraad" name="voorraad" min="0" required>

            <label for="leverancier_id">Leverancier:</label>
            <select id="leverancier_id" name="leverancier_id" required>
                <option value="">-- Kies een leverancier --</option>
                <?php foreach ($leveranciers as $l): ?>
                    <option value="<?= $l['leverancier_id'] ?>">
                        <?= htmlspecialchars($l['bedrijfsnaam']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br><br>
            <button type="submit" class="btn">Opslaan</button>
        </form>
    </div>
</main>

<!-- Producten tabel -->
<div class="order-box">
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Naam</th>
                <th>Omschrijving</th>
                <th>Prijs</th>
                <th>Voorraad</th>
                <th>Leverancier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($producten as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['product_id']) ?></td>
                <td><?= htmlspecialchars($p['naam']) ?></td>
                <td><?= htmlspecialchars($p['omschrijving']) ?></td>
                <td>€<?= htmlspecialchars(number_format($p['prijs'], 2, ',', '.')) ?></td>
                <td><?= htmlspecialchars($p['voorraad']) ?></td>
                <td><?= htmlspecialchars($p['leverancier']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="/IntertoysOMS/Javascript/OrderPopUp.js"></script>
</body>
</html>
