<?php
/**
 * LeveranciersModel
 *
 * Auteur: Milan
 * Beschrijving: Bevat alle database functies voor leveranciers.
 */
class LeveranciersModel {

    // Voeg een nieuwe leverancier toe.
    public static function add($conn, $data) {
        $stmt = $conn->prepare(
            "INSERT INTO Leverancier (bedrijfsnaam, adres, contactpersoon, email) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "ssss", 
            $data['bedrijfsnaam'], 
            $data['adres'], 
            $data['contactpersoon'], 
            $data['email']
        );
        return $stmt->execute();
    }

    // Update een bestaande leverancier.
    public static function update($conn, $data) {
        $stmt = $conn->prepare(
            "UPDATE Leverancier SET bedrijfsnaam=?, adres=?, contactpersoon=?, email=? WHERE leverancier_id=?"
        );
        $stmt->bind_param(
            "ssssi", 
            $data['bedrijfsnaam'], 
            $data['adres'], 
            $data['contactpersoon'], 
            $data['email'], 
            $data['leverancier_id']
        );
        return $stmt->execute();
    }

    // Verwijder een leverancier.
    public static function delete($conn, $id) {
        $stmt = $conn->prepare("DELETE FROM Leverancier WHERE leverancier_id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Haal alle leveranciers op.
    public static function getAll($conn) {
        $sql = "SELECT leverancier_id, bedrijfsnaam, adres, contactpersoon, email 
                FROM Leverancier 
                ORDER BY bedrijfsnaam ASC";
        $result = $conn->query($sql);

        $leveranciers = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $leveranciers[] = $row;
            }
        }
        return $leveranciers;
    }
}
?>
