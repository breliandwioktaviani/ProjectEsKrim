<?php
class Database {
    private $host = namehost ;
    private $username = username ;      
    private $password = password ;
    private $dbname = dbname ;
    private $port = port ;
    private $conn;

    public function connection() {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
    throw new Exception("Koneksi ke database gagal: " . $exception->getMessage());
    }
        return $this->conn;
    }
}
