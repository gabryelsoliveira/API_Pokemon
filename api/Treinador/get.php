<?php
  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../../Config/Database.php';
include_once '../../Models/Treinador.php';
 
use API_Pokemon\Config\Database; 
use API_Pokemon\Models\Treinador; 
 
$database = new Database();
$db = $database->getConnection();
 
$treinador = new Treinador($db);
 
$treinador->id = isset($_GET['id']) ? $_GET['id'] : null;
 
try {
 
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {  
 
        if ($treinador->id) {
 
            $treinador->get();
 
            if ($treinador->nome != null) {
 
               
            $treinador_arr = array(
                "id" => $treinador->id,
                "nome" => $treinador->nome,
                "genero" => $treinador->genero,
                "idade" => $treinador->idade,
                "cidadeOrigem" => $treinador->cidadeOrigem,
                "regiao" => $treinador->regiao,
                "insignias" => $treinador->insignias
            );
 
 
            http_response_code(200);  
            echo json_encode($treinador_arr, JSON_PRETTY_PRINT);
           
            } else {
 
                http_response_code(404); 
                echo json_encode(
                    array("Mensagem" => "Treinador não encontrado.")
                );
            }
 
        } else {
 
            http_response_code(400); 
            echo json_encode(
                array("Mensagem" => "ID não informado.")
            );
        }
 
    } else {
 
        http_response_code(405); 
        echo json_encode(
            array("Mensagem" => "Método não permitido.")
        );
    }
 
   
 
} catch (PDOException $e) { 
 
    http_response_code(500); 
    echo json_encode(
        array("Mensagem" => "Erro ao buscar o treinador: " . $e->getMessage())
    );
 
} catch (Throwable $e) {
 
    http_response_code(500);
    echo json_encode(
        array("Mensagem" => "Erro inesperado: " . $e->getMessage())
    );
}
 