<?php 

class FavoritController
{
    public function __construct(private FavoritGateway $gateway)
    {
    }

    public function processRequestFavorit(string $method, ?string $id):void
    {
        if ($id){
            
            $this->processResourceRequestFavorit($method, $id);

        } else {

            $this->processCollectionRequestFavorit($method);
           
        }
    }
    //proses data berdasarkan id
    private function processResourceRequestFavorit(string $method, string $id): void
    {
        $favId = $this->gateway->getIdFavorit($id);
        
        if (!$favId){
            http_response_code(404);
            echo json_encode(["message" => "Makanan Tidak Ditemukan"]);
            return;
        }

        switch ($method){
            case "GET":
                echo json_encode($favId);
                break;
            // UPDATE data
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);
                if (!empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->updateFavorit($favId, $data);
                echo json_encode([
                    "message" => "Makanan Favorit $id terupdate",
                    "rows" => $rows
                ]);
                break;
        }
    }

    //proses semua data di tabel
    private function processCollectionRequestFavorit(string $method): void
    {
        switch ($method){
            case "GET":
                echo json_encode($this->gateway->getFavorit());
                break;

            case "POST":
                // TODO: cek apa output $_POST harus di konversi lagi ato bisa biar aja output rawnya
                $data = (array) json_decode(file_get_contents("php://input"), true);
                // $data = (array) json_decode(json_encode($_POST),  true);


                $errors = $this->getValidationErrors($data);
                if (!empty($errors)){
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                // var_dump($data);
                $id = $this->gateway->addFavorit($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Product created",
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
        if (empty($data["id_makanan"])){
            $errors[] = "id_makanan tidak boleh kosong";
        }

        //check input size biar ga 0
        if (array_key_exists("id_pelanggan", $data)){

            if (filter_var($data["id_pelanggan"], FILTER_VALIDATE_INT) === false){
                $errors[] = "id pelanggan haruslah integer";
            }
        }

        return $errors;
    }
}
?>