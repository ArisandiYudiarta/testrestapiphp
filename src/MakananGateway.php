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

    public function searchMakanan($data): array
    {
        $nama = isset($data['nama_makanan']) ? $data['nama_makanan'] : '';
        $kategori = isset($data['kategori']) ? $data['kategori'] : '';
        $merk = isset($data['merk']) ? $data['merk'] : '';
        
        // var_dump($nama, $gambar, $berat, $deskripsi, $kategori, $usia, $komposisi, $merk, $rating);
        // die;

        if (!empty($nama) && !empty($kategori) && !empty($merk)) {
            $query = "SELECT * FROM makanan WHERE nama_makanan LIKE :nama_makanan AND kategori LIKE :kategori  AND merk LIKE :merk";

            $statement = $this->conn->prepare($query);
            $statement->bindValue(":nama_makanan", '%' . $data["nama_makanan"] . '%', PDO::PARAM_STR);
            $statement->bindValue(":kategori", '%' . $data["kategori"] . '%', PDO::PARAM_STR);
            $statement->bindValue(":merk", '%' . $data["merk"] . '%', PDO::PARAM_STR);
        
        } elseif (!empty($nama) && !empty($kategori)) {
            $query = "SELECT * FROM makanan WHERE nama_makanan LIKE :nama_makanan AND kategori LIKE :kategori";

            $statement = $this->conn->prepare($query);
            $statement->bindValue(":nama_makanan", '%' . $data["nama_makanan"] . '%', PDO::PARAM_STR);
            $statement->bindValue(":kategori", '%' . $data["kategori"] . '%', PDO::PARAM_STR);
            
        } elseif (!empty($nama) && !empty($merk)) {
            $query = "SELECT * FROM makanan WHERE nama_makanan LIKE :nama_makanan AND merk LIKE :merk";

            $statement = $this->conn->prepare($query);
            $statement->bindValue(":nama_makanan", '%' . $data["nama_makanan"] . '%', PDO::PARAM_STR);
            $statement->bindValue(":merk", '%' . $data["merk"] . '%', PDO::PARAM_STR);
        
        } elseif (!empty($kategori) && !empty($merk)) {
            $query = "SELECT * FROM makanan WHERE kategori LIKE :kategori AND merk LIKE :merk";

            $statement = $this->conn->prepare($query);
            $statement->bindValue(":kategori", '%' . $data["kategori"] . '%', PDO::PARAM_STR);
            $statement->bindValue(":merk", '%' . $data["merk"] . '%', PDO::PARAM_STR);

        } elseif (!empty($nama)) {
            $query = "SELECT * FROM makanan WHERE nama_makanan LIKE :nama_makanan";

            $statement = $this->conn->prepare($query);
            $statement->bindValue(":nama_makanan", '%' . $data["nama_makanan"] . '%', PDO::PARAM_STR);
            
        } elseif (!empty($kategori)) {
            $query = "SELECT * FROM makanan WHERE kategori LIKE :kategori";

            
            $statement = $this->conn->prepare($query);
            $statement->bindValue(":kategori", '%' . $data["kategori"] . '%', PDO::PARAM_STR);

        } elseif (!empty($merk)) {
            $query = "SELECT * FROM makanan WHERE merk LIKE :merk";

            $statement = $this->conn->prepare($query);
            $statement->bindValue(":merk", '%' . $data["merk"] . '%', PDO::PARAM_STR);
        }

        $statement->execute();

        $data = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

            $data[] = $row;
        }

        if (empty($data)){
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

    public function get(string $id): array
    {
        $sql = "SELECT * FROM makanan WHERE id_makanan = :id_makanan";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id_makanan", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data;
    }
    
}
?>