<?php 

class MakananController
{
    public function __construct(private MakananGateway $gateway)
    {
    }

    public function processRequestMakanan(string $method, ?string $id):void
    {
        if ($id == "search"){
            
            $this->processSearchMakanan($method, $id);

        }if ($id){
            
            $this->processResourceRequestMakanan($method, $id);

        } else {

            $this->processCollectionRequestmakanan($method);
           
        }
    }

    private function processSearchMakanan(string $method, string $id): void
    {
        switch ($method){
            case "GET":
                $data = $_GET;

                echo json_encode($result = $this->gateway->searchMakanan($data));
                break;

            //default output (method not allowed)
            default:
                http_response_code(405);
                header("Allow: GET");
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
                $data = $_POST;


                $errors = $this->getValidationErrors($data);
                if (!empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                // var_dump($data);
                $id = $this->gateway->addMakanan($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Makanan Tersimpan",
                    "id" => $id
                ]);
                break;

            //default output (method not allowed)
            default:
                http_response_code(405);
                header("Allow: GET,POST");
        }
    }

    //data validation
    private function getValidationErrors(array $data): array
    {
        $errors = [];

        // cek data 
        if (empty($data["nama_makanan"])){
            $errors[] = "nama makanan tidak boleh kosong";
        }

        //check input size biar ga 0
        if (array_key_exists("berat", $data)){

            if (filter_var($data["berat"], FILTER_VALIDATE_INT) === false){
                $errors[] = "berat haruslah integer";
            }
        }

        return $errors;
    }
}
?>