<?php
include('../Includes/DB.php');
include('../Model/OrdersModel.php');

$orders = getOrders($conn);
$users = getUsers($conn);
$producten = getProducten($conn);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="/styles/Orders.css">
</head>
<body>
<a href="/View/Dashboard.php" class="linkNaarDashboard">Intertoys OMS</a>

<main>
    <h2>Orders</h2>
    <button class="btn" id="openFormBtn">Order Toevoegen</button>

    <!-- Formulier voor nieuwe order -->
    <div id="orderFormContainer" style="display:none; margin-top:20px;">
        <form action="../Controller/OrdersController.php" method="post">
            <input type="hidden" name="action" value="add">
            
            <label for="user_id">Klant:</label>
            <select id="user_id" name="user_id" required>
                <option value="">-- Kies een klant --</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['user_id'] ?>"><?= htmlspecialchars($u['voornaam'] . ' ' . $u['achternaam']) ?></option>
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
                            <option value="<?= $p['product_id'] ?>"><?= htmlspecialchars($p['naam']) ?></option>
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
                <tr class="order-row" data-order-id="<?= $o['order_id'] ?>" style="cursor:pointer;">
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

    <!-- Formulier voor bewerken/verwijderen -->
    <div id="editOrderForm" style="display:none; margin-top:20px;">
        <form action="../Controller/OrdersController.php" method="post">
            <input type="hidden" name="order_id" id="edit_order_id">
            <input type="hidden" name="action" value="update">

            <label>Klant:</label>
            <select name="user_id" id="edit_user_id" required>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['user_id'] ?>"><?= htmlspecialchars($u['voornaam'] . ' ' . $u['achternaam']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Orderdatum:</label>
            <input type="date" name="datum" id="edit_datum" required>

            <label>Status:</label>
            <select name="status" id="edit_status">
                <option value="In behandeling">In behandeling</option>
                <option value="Verzonden">Verzonden</option>
                <option value="Afgerond">Afgerond</option>
            </select>

            <br><br>
            <button type="submit" class="btn">Opslaan</button>
        </form>

        <form action="../Controller/OrdersController.php" method="post" style="margin-top:10px;">
            <input type="hidden" name="order_id" id="delete_order_id">
            <input type="hidden" name="action" value="delete">
            <button type="submit" style="background:red; color:white;">Verwijderen</button>
        </form>
    </div>
</main>

<script src="../Javascript/OrderPopUp.js"></script>
<script>
document.querySelectorAll(".order-row").forEach(row => {
    row.addEventListener("click", () => {
        const orderId = row.dataset.orderId;
        const klant = row.children[2].textContent;
        const datum = row.children[1].textContent;
        const status = row.children[3].textContent;

        document.getElementById("editOrderForm").style.display = "block";
        document.getElementById("edit_order_id").value = orderId;
        document.getElementById("delete_order_id").value = orderId;
        document.getElementById("edit_datum").value = datum;

        const userSelect = document.getElementById("edit_user_id");
        for (let option of userSelect.options) {
            if (option.text === klant) option.selected = true;
        }

        document.getElementById("edit_status").value = status;
        window.scrollTo(0, document.getElementById("editOrderForm").offsetTop);
    });
});
</script>

</body>
</html>
