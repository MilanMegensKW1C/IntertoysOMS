<?php
/*
 * Leveranciers.php
 *
 * Auteur: Milan
 * Beschrijving: Pagina voor het beheren van leveranciers. Laat leveranciers zien, toevoegen, bewerken en verwijderen.
 */

include('../Includes/DB.php');               // Database connectie
include('../Model/LeveranciersModel.php');   // Leveranciers model

session_start();

// Controleer of gebruiker ingelogd is en de juiste rol heeft
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['Admin', 'Productmanager'])) {
    // Visuele waarschuwing en redirect naar dashboard
    echo "<script>
            alert('Geen toegang tot deze pagina! Je wordt teruggestuurd naar het dashboard.');
            window.location.href='/View/Dashboard.php';
          </script>";
    exit;
}

// Rol beschikbaar maken voor eventuele checks
$rol = $_SESSION['rol'];

// Leveranciers ophalen uit de database
$leveranciers = LeveranciersModel::getAll($conn) ?? [];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leveranciers</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../styles/leveranciers.css">
    <!-- JS voor popups -->
    <script src="../Javascript/LeverancierPopup.js" defer></script>
</head>
<body>
<!-- Link naar dashboard -->
<h1>
    <a href="/View/Dashboard.php" class="linkNaarDashboard">Intertoys OMS</a>
</h1>

<main>
    <h2>Leveranciers</h2>
    <button class="btn" id="openFormBtn">Leverancier Toevoegen</button>

    <!-- Toevoegen popup -->
    <div id="leverancierFormContainer" class="modal">
        <div class="modal-content">
            <span class="closeBtn">&times;</span>
            <h3>Nieuwe leverancier toevoegen</h3>
            <form action="/Controller/LeveranciersController.php" method="post">
                <label>Bedrijfsnaam:</label>
                <input type="text" name="bedrijfsnaam" required>

                <label>Adres:</label>
                <input type="text" name="adres" required>

                <label>Contactpersoon:</label>
                <input type="text" name="contactpersoon" required>

                <label>Email:</label>
                <input type="email" name="email" required>

                <button type="submit" class="btn" id="saveBtn">Opslaan</button>
            </form>
        </div>
    </div>
</main>

<!-- Leveranciers tabel -->
<div class="order-box">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Bedrijfsnaam</th>
                <th>Adres</th>
                <th>Contactpersoon</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($leveranciers)): ?>
                <?php foreach ($leveranciers as $l): ?>
                <tr>
                    <td><?= htmlspecialchars($l['leverancier_id']) ?></td>
                    <td><?= htmlspecialchars($l['bedrijfsnaam']) ?></td>
                    <td><?= htmlspecialchars($l['adres']) ?></td>
                    <td><?= htmlspecialchars($l['contactpersoon']) ?></td>
                    <td><?= htmlspecialchars($l['email']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Geen leveranciers gevonden</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bewerken / Verwijderen popup -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="closeBtn">&times;</span>
        <h3>Leverancier bewerken</h3>
        <form id="editForm" method="post">
            <!-- Hidden veld voor leverancier_id -->
            <input type="hidden" name="leverancier_id" id="edit_id">

            <label>Bedrijfsnaam:</label>
            <input type="text" name="bedrijfsnaam" id="edit_bedrijfsnaam" required>

            <label>Adres:</label>
            <input type="text" name="adres" id="edit_adres" required>

            <label>Contactpersoon:</label>
            <input type="text" name="contactpersoon" id="edit_contactpersoon" required>

            <label>Email:</label>
            <input type="email" name="email" id="edit_email" required>

            <button type="submit" class="btn" id="saveBtn">Opslaan</button>
            <button type="button" class="btn" id="deleteBtn">Verwijderen</button>
        </form>
    </div>
</div>
</body>
</html>
