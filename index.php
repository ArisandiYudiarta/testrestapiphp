<?php 

declare(strict_types=1);

spl_autoload_register(function ($class){
    require __DIR__ . "/src/$class.php";
});

//import error handler
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

//convert output ke json
header("Content-type: application/json; charset=UTF-8");

//pecah link u
$parts = explode("/", $_SERVER['REQUEST_URI']);

// catch id dari link
$id = $parts[3] ?? null;

//connect ke database
$database = new Database("localhost", "makanan_hewan", "root", "");

//catch part dari link
if ($parts[2] == "makanan") {

    $gateway = new MakananGateway($database);
 
    $controller = new MakananController($gateway);
    
    $controller->processRequestMakanan($_SERVER["REQUEST_METHOD"], $id);
}elseif ($parts[2] == "favorit") {

    $gateway = new FavoritGateway($database);
 
    $controller = new FavoritController($gateway);
    
    $controller->processRequestFavorit($_SERVER["REQUEST_METHOD"], $id);
}else{
    http_response_code(404);
    exit;
}

?>