<?php 

class ProductController
{
    public function __construct(private ProductGateway $gateway)
    {
    }

    public function processRequest(string $method, ?string $id):void
    {
        if ($id){
            
            $this->processResourceRequest($method, $id);

        } else {

            $this->processCollectionRequest($method);
           
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {

    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method){
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                // TODO: cek apa output $_POST harus di konversi lagi ato bisa biar aja output rawnya
                $data = (array) json_decode(json_encode($_POST),  true);

                var_dump($data);
        }
    }
}
?>