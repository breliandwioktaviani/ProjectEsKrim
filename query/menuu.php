<?php

class Menu
{
private $con;
private $table = "t_menu";
public $id_menu, $nama_menu, $harga_menu, $gambar_menu;

public function __construct($db)
{
    $this->con = $db;
}

public function create()
{
    $query = "INSERT INTO {$this->table} (nama_menu, harga_menu, gambar_menu) VALUES (:nama_menu, :harga_menu, :gambar_menu)";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":nama_menu", $this->nama_menu);
    $statement->bindParam(":harga_menu", $this->harga_menu);
    $statement->bindParam(":gambar_menu", $this->gambar_menu);
    return $statement->execute();
}

public function update()
{
 $query ="UPDATE {$this->table} SET nama_menu = :nama_menu, harga_menu = :harga_menu, gambar_menu = :gambar_menu WHERE id_menu = :id_menu";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":nama_menu", $this->nama_menu);
    $statement->bindParam(":harga_menu", $this->harga_menu);
    $statement->bindParam(":gambar_menu", $this->gambar_menu);
    $statement->bindParam(":id_menu", $this->id_menu);
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
 $query ="DELETE FROM {$this->table} WHERE id_menu = :id_menu";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":id_menu", $this->id_menu);
    return $statement->execute();
}

public function cari($id)
{
 $statement = $this->con->prepare("SELECT * FROM {$this->table} WHERE id_menu=?");
    
    $statement->execute([$id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

public function search($keyword)
{
    $query = "SELECT * FROM t_menu WHERE nama_menu LIKE :keyword";
    $stmt = $this->con->prepare($query);
    $stmt->bindValue(':keyword', '%' . $keyword . '%');
    $stmt->execute();
    return $stmt;
}

}
?>