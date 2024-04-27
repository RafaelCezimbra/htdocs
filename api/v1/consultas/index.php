<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/conexao/MysqliConnection.php';
use api\conexao\MysqliConnection;
$conn = MysqliConnection::getInstance()->getConnection();

$method = $_SERVER['REQUEST_METHOD'];


// HTTP METHOD CONSTANTS
define("METHOD_GET", "GET");
define("METHOD_POST", "POST");
define("METHOD_DELETE", "DELETE");

switch ($method) {
    case METHOD_GET:
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(array(
                "title" => "Error",
                "message" => "GET IS NOT ALLOWED."
            ));
        break;

    case METHOD_POST:
        try {
            // form data
            $nome = $_POST["nome"];

            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode(array(
                "title" => "Success",
                "message" => "Dado criado com sucesso.",
            ));
        } catch(Exception $e) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(array(
                "title" => "Error",
                "message" => $e
            ));
        }
        break;

    case METHOD_DELETE:
      try {
                // form data
                $nome = $_POST["nome"];
    
                http_response_code(201);
                header('Content-Type: application/json');
                echo json_encode(array(
                    "title" => "Success",
                    "message" => "Dado criado com sucesso.",
                ));
            } catch(Exception $e) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(array(
                    "title" => "Error",
                    "message" => $e
                ));
            }
            break;

    default:
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode(array(
            "title" => "Error",
            "message" => $method . "IS NOT ALLOWED"
        ));
}
?>