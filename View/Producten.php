<?php
include(__DIR__ . '/../Includes/DB.php');
include(__DIR__ . '/../Model/ProductModel.php');

$producten = getProducten($conn);
$leveranciers = getLeveranciers($conn);
?>

<link rel="stylesheet" href="/styles/Orders.css">
<script src="../Javascript/ProductPopUp.js" defer></script>

<body>
<a href="/View/Dashboard.php" class="linkNaarDashboard">Intertoys OMS</a>

<main>
    <h2>Producten</h2>
    <button class="btn" id="openFormBtn">Product Toevoegen</button>

    <!-- Verborgen formulier toevoegen/bewerken -->
<div id="productFormContainer" style="display: none; margin-top: 20px;">
    <form action="../Controller/ProductController.php" method="post">
            <input type="hidden" name="product_id" id="form_product_id">
            <input type="hidden" name="action" id="form_action" value="add">

            <label>Naam:</label>
            <input type="text" name="naam" id="form_naam" required>

            <label>Omschrijving:</label>
            <textarea name="omschrijving" id="form_omschrijving" required></textarea>

            <label>Prijs (€):</label>
            <input type="number" name="prijs" id="form_prijs" step="0.01" required>

            <label>Voorraad:</label>
            <input type="number" name="voorraad" id="form_voorraad" min="0" required>

            <label>Leverancier:</label>
            <select name="leverancier_id" id="form_leverancier_id" required>
                <option value="">-- Kies een leverancier --</option>
                <?php foreach ($leveranciers as $l): ?>
                    <option value="<?= $l['leverancier_id'] ?>"><?= htmlspecialchars($l['bedrijfsnaam']) ?></option>
                <?php endforeach; ?>
            </select>

            <br><br>
            <button type="submit" class="btn">Opslaan</button>
        </form>

        <!-- Verwijderknop -->
        <form action="../Controller/ProductController.php" method="post" style="margin-top:10px;">
            <input type="hidden" name="product_id" id="delete_product_id">
            <input type="hidden" name="action" value="delete">
            <button type="submit" style="background:red; color:white;">Verwijderen</button>
        </form>
    </div>
</main>

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
            <tr class="product-row" data-product-id="<?= $p['product_id'] ?>" style="cursor:pointer;">
                <td><?= $p['product_id'] ?></td>
                <td><?= htmlspecialchars($p['naam']) ?></td>
                <td><?= htmlspecialchars($p['omschrijving']) ?></td>
                <td>€<?= number_format($p['prijs'], 2, ',', '.') ?></td>
                <td><?= $p['voorraad'] ?></td>
                <td><?= htmlspecialchars($p['leverancier']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const formContainer = document.getElementById("productFormContainer");
    const productForm = document.getElementById("productForm");
    const deleteInput = document.getElementById("delete_product_id");

    document.querySelectorAll(".product-row").forEach(row => {
        row.addEventListener("click", () => {
            const cols = row.children;
            document.getElementById("form_product_id").value = row.dataset.productId;
            document.getElementById("form_action").value = "update";
            document.getElementById("form_naam").value = cols[1].textContent;
            document.getElementById("form_omschrijving").value = cols[2].textContent;
            document.getElementById("form_prijs").value = cols[3].textContent.replace('€','').replace('.','').replace(',','.');
            document.getElementById("form_voorraad").value = cols[4].textContent;
            
            // Select juiste leverancier
            const select = document.getElementById("form_leverancier_id");
            for (let opt of select.options) {
                if (opt.text === cols[5].textContent) opt.selected = true;
            }

            deleteInput.value = row.dataset.productId;
            formContainer.style.display = "block";
            window.scrollTo(0, formContainer.offsetTop);
        });
    });
});
</script>
