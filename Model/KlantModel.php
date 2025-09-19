

<?php
function getKlanten($conn) {
    $sql = "SELECT user_id, voornaam, achternaam, email, rol FROM User ORDER BY voornaam ASC";
    $result = $conn->query($sql);

    $klanten = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $klanten[] = $row;
        }
    }
    return $klanten;
}
function updateUser($conn, $user_id, $voornaam, $achternaam, $email, $rol) {
    $stmt = $conn->prepare("UPDATE User SET voornaam = ?, achternaam = ?, email = ?, rol = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $voornaam, $achternaam, $email, $rol, $user_id);
    $stmt->execute();
    $stmt->close();
}

function deleteUser($conn, $user_id) {
    $stmt = $conn->prepare("DELETE FROM User WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

function addUser($conn, $voornaam, $achternaam, $email, $rol) {
    $stmt = $conn->prepare("INSERT INTO User (voornaam, achternaam, email, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $voornaam, $achternaam, $email, $rol);
    $stmt->execute();
    $stmt->close();
}
?>
