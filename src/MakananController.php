<?php 

class MakananController
{
    public function __construct(private MakananGateway $gateway)
    {
    }

    public function processRequestMakanan(string $method, ?string $id):void
    {
        if ($id){
            
            $this->processResourceRequestMakanan($method, $id);

        } else {

            $this->processCollectionRequestmakanan($method);
           
        }
    }

    private function processResourceRequestMakanan(string $method, string $id): void
    {

    }

    private function processCollectionRequestMakanan(string $method): void
    {
        switch ($method){
            case "GET":
                echo json_encode($this->gateway->getMakanan());
                break;

            case "POST":
                // TODO: cek apa output $_POST harus di konversi lagi ato bisa biar aja output rawnya
                //TESTING PURPOSES (paste this in the raw section on postman)
                $dataRaw = file_get_contents("php://input");
                $data = json_decode($dataRaw);
                // json_last_error();
                // $data = (array) json_decode(json_encode($_POST),  true);
                // $data = $_POST;

                var_dump($data);
        }
    }
}
?>