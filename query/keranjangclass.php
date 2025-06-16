<?php
class Keranjang {
    private $conn;
    private $table_name = "t_keranjang";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($id_pelanggan, $id_menu) {
        $query = "SELECT jumlah_menu FROM " . $this->table_name . " WHERE id_pelanggan = :id_pelanggan AND id_menu = :id_menu";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pelanggan', $id_pelanggan);
        $stmt->bindParam(':id_menu', $id_menu);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $jumlahBaru = $row['jumlah_menu'] + 1;

            $update = "UPDATE " . $this->table_name . " SET jumlah_menu = :jumlah_menu WHERE id_pelanggan = :id_pelanggan AND id_menu = :id_menu";
            $stmtUpdate = $this->conn->prepare($update);
            $stmtUpdate->bindParam(':jumlah_menu', $jumlahBaru);
            $stmtUpdate->bindParam(':id_pelanggan', $id_pelanggan);
            $stmtUpdate->bindParam(':id_menu', $id_menu);
            return $stmtUpdate->execute();
        } else {
            $insert = "INSERT INTO " . $this->table_name . " (id_pelanggan, id_menu, jumlah_menu) VALUES (:id_pelanggan, :id_menu, 1)";
            $stmtInsert = $this->conn->prepare($insert);
            $stmtInsert->bindParam(':id_pelanggan', $id_pelanggan);
            $stmtInsert->bindParam(':id_menu', $id_menu);
            return $stmtInsert->execute();
        }
    }

    public function getByUser($id_pelanggan) {
        $query = "SELECT t_keranjang.id_menu, t_menu.nama_menu, t_menu.harga_menu, t_menu.gambar_menu, t_keranjang.jumlah_menu 
                  FROM " . $this->table_name . " t_keranjang 
                  JOIN t_menu ON t_keranjang.id_menu = t_menu.id_menu 
                  WHERE t_keranjang.id_pelanggan = :id_pelanggan";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pelanggan', $id_pelanggan);
        $stmt->execute();
        return $stmt;
    }

    public function updateJumlah($id_pelanggan, $id_menu, $jumlah_menu) {
        $query = "UPDATE t_keranjang SET jumlah_menu = :jumlah_menu 
              WHERE id_pelanggan = :id_pelanggan AND id_menu = :id_menu";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":jumlah_menu", $jumlah_menu);
        $stmt->bindParam(":id_pelanggan", $id_pelanggan);
        $stmt->bindParam(":id_menu", $id_menu);
        return $stmt->execute();
    }


    public function updateQuantity($id_pelanggan, $id_menu, $jumlah_menu) {
        $query = "UPDATE " . $this->table_name . " SET jumlah_menu = :jumlah_menu WHERE id_pelanggan = :id_pelanggan AND id_menu = :id_menu";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':jumlah_menu', $jumlah_menu);
        $stmt->bindParam(':id_pelanggan', $id_pelanggan);
        $stmt->bindParam(':id_menu', $id_menu);
        return $stmt->execute();
    }

    public function delete($id_pelanggan, $id_menu) {
    $query = "DELETE FROM t_keranjang WHERE id_pelanggan = :id_pelanggan AND id_menu = :id_menu";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id_pelanggan", $id_pelanggan);
    $stmt->bindParam(":id_menu", $id_menu);
    return $stmt->execute();
    }

}
?>