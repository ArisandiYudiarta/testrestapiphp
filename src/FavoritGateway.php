<?php

class FavoritGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getFavorit(): array 
    {
        $sql = "SELECT makanan_favorit.id_makanan_favorit, makanan.nama_makanan, makanan.gambar, pelanggan.username
                FROM makanan
                JOIN makanan_favorit ON makanan.id_makanan=makanan_favorit.id_makanan
                JOIN pelanggan ON makanan_favorit.id_pelanggan=pelanggan.id_pelanggan";

        $statement = $this->conn->query($sql);

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            $data[] = $row;
        }

        return $data; 
    }
    
    //tambah data
    public function addFavorit(array $data):string
    {
        $sql = "INSERT INTO makanan_favorit (id_makanan, id_pelanggan)
                VALUES (:id_makanan, :id_pelanggan)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id_makanan", $data["id_makanan"], PDO::PARAM_INT);
        $stmt->bindValue(":id_pelanggan", $data["id_pelanggan"], PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    //req id makanan favorit
    public function getIdFavorit(string $id): array | false
    {
        $sql = "SELECT * FROM makanan_favorit WHERE id_makanan_favorit = :id_makanan_favorit";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id_makanan_favorit", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    public function updateFavorit(array $current, array $new): int
    {
        $sql = "UPDATE makanan_favorit
                SET id_makanan = :id_makanan, id_pelanggan = :id_pelanggan
                WHERE id_makanan_favorit = :id_makanan_favorit";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id_makanan", $new["id_makanan"] ?? $current["id_makanan"],
        PDO::PARAM_INT);
        $stmt->bindValue(":id_pelanggan", $new["id_pelanggan"] ?? $current["id_pelanggan"],
        PDO::PARAM_INT);

        $stmt->bindValue(":id_makanan_favorit", $current["id_makanan_favorit"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
} 
?>