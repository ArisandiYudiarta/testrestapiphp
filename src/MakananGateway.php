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

    public function searchMakanan($data)
    {


        // $sql = "SELECT * FROM makanan WHERE nama_makanan LIKE :nama_makanan AND kategori = :kateori";
        $sql = "SELECT * FROM makanan WHERE nama_makanan LIKE :nama_makanan AND kategori LIKE :kateori";

        var_dump($data["nama_makanan"]);

        $statement = $this->conn->prepare($sql);
        $statement->bindValue(":nama_makanan", '%' . $data["nama_makanan"] . '%', PDO::PARAM_STR);
        $statement->bindValue(":kateori", '%' . $data["kategori"] . '%', PDO::PARAM_INT);
        $statement->execute();

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            $data[] = $row;
        }

        if (empty($data)) {
            return 0;
        }

        return $data; 
    }

    public function addMakanan(array $data): int
    {
        $sql = "INSERT INTO makanan (nama_makanan, gambar, berat, deskripsi, kategori, usia_pemakaian, komposisi, merk, rating)
                VALUES (:nama_makanan, :gambar, :berat, :deskripsi, :kategori, :usia_pemakaian, :komposisi, :merk, :rating)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":nama_makanan", $data["nama_makanan"], PDO::PARAM_STR);
        $stmt->bindValue(":gambar", $data["gambar"], PDO::PARAM_STR);
        $stmt->bindValue(":berat", $data["berat"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":deskripsi", $data["deskripsi"], PDO::PARAM_STR);
        $stmt->bindValue(":kategori", $data["kategori"], PDO::PARAM_STR);
        $stmt->bindValue(":usia_pemakaian", $data["usia_pemakaian"], PDO::PARAM_INT);
        $stmt->bindValue(":komposisi", $data["komposisi"], PDO::PARAM_STR);
        $stmt->bindValue(":merk", $data["merk"], PDO::PARAM_STR);
        $stmt->bindValue(":rating", $data["rating"], PDO::PARAM_INT);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    

} 
?>