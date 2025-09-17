<?php
class FacturenModel {

    // Haal alle facturen op met bijbehorende order info
    public static function getAll($conn) {
        $sql = "
            SELECT f.factuur_id, f.order_id, f.factuurdatum, f.totaalbedrag,
                   o.orderdatum, o.status, o.user_id
            FROM factuur f
            JOIN `order` o ON f.order_id = o.order_id
            ORDER BY f.factuurdatum DESC
        ";

        $result = $conn->query($sql);
        $facturen = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $facturen[] = $row;
            }
        }
        return $facturen;
    }

    // Factuur toevoegen
    public static function add($conn, $data) {
        $stmt = $conn->prepare("INSERT INTO factuur (order_id, factuurdatum, totaalbedrag) VALUES (?, ?, ?)");
        $stmt->bind_param("isd", $data['order_id'], $data['factuurdatum'], $data['totaalbedrag']);
        $stmt->execute();
    }

    // Factuur updaten
    public static function update($conn, $data) {
        $stmt = $conn->prepare("UPDATE factuur SET order_id=?, factuurdatum=?, totaalbedrag=? WHERE factuur_id=?");
        $stmt->bind_param("isdi", $data['order_id'], $data['factuurdatum'], $data['totaalbedrag'], $data['factuur_id']);
        $stmt->execute();
    }

    // Factuur verwijderen
    public static function delete($conn, $factuur_id) {
        $stmt = $conn->prepare("DELETE FROM factuur WHERE factuur_id=?");
        $stmt->bind_param("i", $factuur_id);
        $stmt->execute();
    }
}
?>
