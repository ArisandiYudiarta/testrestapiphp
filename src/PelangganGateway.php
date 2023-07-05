<?php

class PelangganGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
    public function getPelanggan(): array 
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
    public function Register(array $data):string
    {   
        $passHash = password_hash($data["password"], PASSWORD_DEFAULT);
        $uname = $data["username"];

        $sql = "INSERT INTO pelanggan(username, password, email, telp)
                VALUES (:username, :pass, :email, :telp)";
                
        $checkQuery = "SELECT * FROM pelanggan WHERE username = :username";

        $cDupe = $this->conn->prepare($checkQuery);
        $cDupe->bindValue(":username", $uname, PDO::PARAM_STR);
        $cDupe->execute();

        $count = $cDupe->rowCount();

        if($count > 0){
            return 1;
        }else{
            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":username", $data["username"], PDO::PARAM_STR);
            $stmt->bindValue(":pass", $passHash, PDO::PARAM_STR);
            $stmt->bindValue(":email", $data["email"], PDO::PARAM_STR);
            $stmt->bindValue(":telp", $data["telp"], PDO::PARAM_STR);
            
            $stmt->execute();

            return $this->conn->lastInsertId(); 
        }   
    }

    public function Logout()
    {
        session_start();
        session_destroy();
    }

    public function Login(array $data): string
    {
        session_start();

        $uname = $data['username'];
        $userpass = $data['password'];

        $sql = "SELECT username, password 
                FROM pelanggan 
                WHERE username = :username";

        $checkQ = $this->conn->prepare($sql);
        $checkQ->bindValue(":username", $data["username"], PDO::PARAM_STR);
        $checkQ->execute();

        $result = $checkQ->fetch();

        // var_dump($result);
        // die;

        $count = $checkQ->rowCount();

        if($count > 0){
            if (password_verify($userpass, $result['password']))
            {
                $_SESSION["username"] = $uname;
                return 1;
            }else{
                return 0;
            }
        }else{
             return 0;
        }   
    }

    public function updatePelanggan(array $current, array $new): int
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