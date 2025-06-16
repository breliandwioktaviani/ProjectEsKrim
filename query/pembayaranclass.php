<?php
class Pembayaran {
    private $conn;
    private $table_name = "t_pembayaran";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Buat transaksi utama
    public function createMainPembayaran($id_pelanggan, $total) {
        $query = "INSERT INTO " . $this->table_name . " (id_pelanggan, total) VALUES (:id_pelanggan, :total)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id_pelanggan' => $id_pelanggan,
            ':total' => $total
        ]);
        return $this->conn->lastInsertId(); // ambil idtransaksi terakhir
    }

    // Tambahkan detail transaksi
    public function addDetail($id_pembayaran, $id_menu, $jumlah_menu, $hargasaatitu) {
    $query = "INSERT INTO pembayaran_detail (id_pembayaran, id_menu, jumlah_menu, hargasaatitu)
              VALUES (:id_pembayaran, :id_menu, :jumlah_menu, :hargasaatitu)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_pembayaran', $id_pembayaran);
    $stmt->bindParam(':id_menu', $id_menu);
    $stmt->bindParam(':jumlah_menu', $jumlah_menu);
    $stmt->bindParam(':hargasaatitu', $hargasaatitu);
    return $stmt->execute();
}

public function readAllPembayaranWithDetails() {
    $query = "
        SELECT 
            t_pembayaran.id_pembayaran,
            t_pelanggan.username AS nama,
            t_menu.nama_menu,
            pembayaran_detail.jumlah_menu,
            pembayaran_detail.hargasaatitu,
            (pembayaran_detail.jumlah_menu * pembayaran_detail.hargasaatitu) AS subtotal
        FROM t_pembayaran
        JOIN t_pelanggan ON t_pembayaran.id_pelanggan = t_pelanggan.id_pelanggan
        JOIN pembayaran_detail ON t_pembayaran.id_pembayaran = pembayaran_detail.id_pembayaran
        JOIN t_menu ON pembayaran_detail.id_menu = t_menu.id_menu
        ORDER BY t_pembayaran.id_pembayaran DESC
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
}
?>