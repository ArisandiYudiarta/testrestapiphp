<?php

class MakananGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getMakanan(): array 
    {
        $sql = "SELECT * FROM makanan";

        $statement = $this->conn->query($sql);

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            $data[] = $row;
        }

        return $data; 
    }

    public function addMakanan(array $data)
    {
        $sql = "INSERT INTO makanan (nama_makanan, gambar, berat)
                VALUES (:nama_makanan, :gambar, :berat)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":nama_makanan", $data["nama_makanan"], PDO::PARAM_STR);
        $stmt->bindValue(":gambar", $data["gambar"], PDO::PARAM_STR);
        $stmt->bindValue(":berat", $data["berat"] ?? 0, PDO::PARAM_INT);
    }
} 
?>