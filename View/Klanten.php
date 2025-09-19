<?php
include(__DIR__ . '/../Includes/DB.php');
include(__DIR__ . '/../Model/KlantModel.php');

session_start();

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['Admin'])) {
    echo "<script>
            alert('Geen toegang tot deze pagina! Je wordt teruggestuurd naar het dashboard.');
            window.location.href='/View/Dashboard.php';
          </script>";
    exit;
}

$rol = $_SESSION['rol'];
$klanten = getKlanten($conn);
?>

<link rel="stylesheet" href="/styles/Orders.css">
<script src="../Javascript/KlantPopUp.js" defer></script>

<h1>
    <a href="/View/Dashboard.php" class="linkNaarDashboard">Intertoys OMS</a>
</h1>

<main>
    <h2>Users</h2>
    <button class="btn" id="openFormBtn">User Toevoegen</button>

<!-- Verborgen formulier voor toevoegen/bewerken -->
<div id="klantFormContainer" style="display:none;">
    <form id="klantForm" action="../Controller/KlantController.php" method="post">
        <input type="hidden" name="user_id" id="form_user_id">
        <input type="hidden" name="action" id="form_action" value="add">

        <label>Voornaam:</label>
        <input type="text" name="voornaam" id="form_voornaam" required>

        <label>Achternaam:</label>
        <input type="text" name="achternaam" id="form_achternaam" required>

        <label>Email:</label>
        <input type="email" name="email" id="form_email" required>

        <label>Rol:</label>
        <select name="rol" id="form_rol" required>
            <option value="admin">Admin</option>
            <option value="medewerker">Medewerker</option>
            <option value="klant">Klant</option>
        </select>

        <br><br>
        <button type="submit">Opslaan</button>
    </form>

    <form action="../Controller/KlantController.php" method="post" style="margin-top:10px;">
        <input type="hidden" name="user_id" id="delete_user_id">
        <input type="hidden" name="action" value="delete">
        <button type="submit" style="background:red; color:white;">Verwijderen</button>
    </form>
</div>

</main>

<div class="order-box">
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Voornaam</th>
                <th>Achternaam</th>
                <th>Email</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($klanten as $k): ?>
            <tr class="klant-row" data-user-id="<?= $k['user_id'] ?>" style="cursor:pointer;">
                <td><?= $k['user_id'] ?></td>
                <td><?= htmlspecialchars($k['voornaam']) ?></td>
                <td><?= htmlspecialchars($k['achternaam']) ?></td>
                <td><?= htmlspecialchars($k['email']) ?></td>
                <td><?= htmlspecialchars($k['rol']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
