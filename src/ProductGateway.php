<?php

class ProductGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array 
    {
        $sql = "SELECT * FROM makanan";

        $statement = $this->conn->query($sql);

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            $data[] = $row;
        }

        return $data; 
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO makanan (nama_makanan, gambar, berat)
                VALUES (:nama_makanan, :gambar, :berat)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":nama_makanan", $data["nama_makanan"], PDO::PARAM_STR);
        $stmt->bindValue(":gambar", $data["gambar"], PDO::PARAM_STR);
        $stmt->bindValue(":berat", $data["berat"], PDO::PARAM_STR);
    }
} 
?>