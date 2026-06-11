<?php
  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';
 
use API_Pokemon\Config\Database; 
use API_Pokemon\Models\Pokemon; 
 
$database = new Database();
$db = $database->getConnection();
 
$pokemon = new Pokemon($db);
 
$pokemon->id = isset($_GET['id']) ? $_GET['id'] : null;
 
try {
 
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {  
 
        if ($pokemon->id) {
 
            $pokemon->get();
 
            if ($pokemon->nome != null) {
 
               
            $pokemon_arr = array(
                "id" => $pokemon->id,
                "nome" => $pokemon->nome,
                "tipo" => $pokemon->tipo,
                "fraqueza" => $pokemon->fraqueza,
                "forca" => $pokemon->forca,
                "velocidade" => $pokemon->velocidade,
                "vida" => $pokemon->vida,
                "resistencia" => $pokemon->resistencia,
                "genero" => $pokemon->genero,
                "idTreinador" => $pokemon->idTreinador
            );
 
            http_response_code(200);  
            echo json_encode($pokemon_arr, JSON_PRETTY_PRINT);
           
            } else {
 
                http_response_code(404); 
                echo json_encode(
                    array("Mensagem" => "Pokemon não encontrado.")
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
        array("Mensagem" => "Erro ao buscar o pokemon: " . $e->getMessage())
    );
 
} catch (Throwable $e) {
 
    http_response_code(500);
    echo json_encode(
        array("Mensagem" => "Erro inesperado: " . $e->getMessage())
    );
}
 