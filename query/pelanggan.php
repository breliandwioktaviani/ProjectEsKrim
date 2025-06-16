<?php

class Pelanggan
{
private $con;
private $table = "t_pelanggan";
public $id_pelanggan, $email, $username, $alamat, $telepon, $password, $role, $gambar_akun;

public function __construct($db)
{
    $this->con = $db;
}

public function create()
{
    $query = "INSERT INTO {$this->table} (email, username, alamat, telepon, password, role, gambar_akun) VALUES (:email, :username, :alamat, :telepon, :password, :role, :gambar_akun)";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":username", $this->username);
    $statement->bindParam(":email", $this->email);
    $statement->bindParam(":alamat", $this->alamat);
    $statement->bindParam(":telepon", $this->telepon);
    $statement->bindParam(":password", $this->password);
    $statement->bindParam(":role", $this->role);
    $statement->bindParam(":gambar_akun", $this->gambar_akun);
    return $statement->execute();
}

public function update()
{
 $query ="UPDATE {$this->table} SET email = :email, username = :username, alamat = :alamat, telepon = :telepon, password = :password, gambar_akun = :gambar_akun  WHERE id_pelanggan = :id_pelanggan";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":email", $this->email);
    $statement->bindParam(":username", $this->username);
    $statement->bindParam(":alamat", $this->alamat);
    $statement->bindParam(":telepon", $this->telepon);
    $statement->bindParam(":password", $this->password);
    $statement->bindParam(":id_pelanggan", $this->id_pelanggan);
    $statement->bindParam(":gambar_akun", $this->gambar_akun);
    return $statement->execute();
}


public function readAll()
{
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->con->prepare($query);
        $statement->execute();
        return $statement;
}
    
public function delete()
{
 $query ="DELETE FROM {$this->table} WHERE id_pelanggan = :id_pelanggan";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":id_pelanggan", $this->id_pelanggan);
    return $statement->execute();
}

public function readById($id_pelanggan) {
            $query = "SELECT * FROM t_pelanggan WHERE id_pelanggan = :id_pelanggan";
            $statement = $this->con->prepare($query);
            $statement->bindParam(':id_pelanggan', $id_pelanggan);
            $statement->execute();
            return $statement;
}

public function cari($id)
{
 $statement = $this->con->prepare("SELECT * FROM {$this->table} WHERE id_pelanggan =?");
    
    $statement->execute([$id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

}
?>