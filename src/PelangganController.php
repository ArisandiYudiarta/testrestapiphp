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
        
        }else {
            
            // $this->processCollectionRequestPelanggan($method);
           
        }
    }

    private function Register(string $method, string $id)
    {
        switch ($method){
            case "POST":
                $data = $_POST;
                // var_dump($data);
                // die;
                $id = $this->gateway->Register($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Registrasi Berhasil",
                    "id" => $id
                ]);
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
                $id = $this->gateway->Register($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Registrasi Berhasil",
                    "id" => $id
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