<?php 

class PelangganController
{
    public function __construct(private PelangganGateway $gateway)
    {
    }

    public function processRequestPelanggan(string $method, ?string $id):void
    {
        if ($id == "register"){
            
            $this->Register($method, $id);
            // var_dump($id)

        }elseif ($id == "login"){
            
            // var_dump($id);
            $this->Login($method, $id);

        }elseif ($id == "logout"){
            
            // var_dump($id);
            $this->Logout($method, $id);
        
        }else {
            
            // $this->processCollectionRequestPelanggan($method);
           
        }
    }

    private function Register(string $method, string $id)
    {
        switch ($method){
            case "POST":
                $data = json_decode(file_get_contents("php://input"), true);
                // $data = $_POST;
                // var_dump($data);
                // die;

                $id = $this->gateway->Register($data);
                
                if ($id == 1){
                    //TODO: masukin error message kalo ada username yang duplikat, kasi juga http response code yang sesuai
                    echo json_encode([
                        "message" => "Username Sudah Terpakai",
                        "id" => $id
                    ]);
                }else{
                    http_response_code(201);
                    echo json_encode([
                        "message" => "Registrasi Berhasil",
                        "id" => $id
                    ]);
                }
                
                break;

            //default output (method not allowed)
            default:
                http_response_code(405);
                header("Allow: POST");
        }
    }

    private function Login(string $method, string $id)
    {
        switch ($method){
            case "POST":
                $data = $_POST;
                // var_dump($data);
                // die;
                $id = $this->gateway->Login($data);

                if ($id == 1){
                    http_response_code(201);
                    echo json_encode([
                        "message" => "Login Berhasil",
                        "id" => $id
                    ]);
                }else{
                    //TODO: masukin error message gagal disini
                    http_response_code(401);
                    echo json_encode([
                        "message" => "Username atau Password Salah",
                        "id" => $id
                    ]);
                }
                break;
            default:
                http_response_code(405);
                header("Allow: POST");
        }
    }

    private function Logout(string $method, string $id)
    {
        switch ($method){
            case "POST":
                // var_dump($data);
                // die;
                $id = $this->gateway->Logout();

                echo json_encode([
                    "message" => "Logout Berhasil"
                ]);
                
                break;

            //default output (method not allowed)
            default:
                http_response_code(405);
                header("Allow: POST");
        }
    }
}
?>