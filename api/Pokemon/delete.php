<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';
 
use API_Pokemon\Config\Database;
use API_Pokemon\Models\Pokemon;  
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pokemon
$pokemon = new Pokemon($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios e se o ID foi fornecido
        if (
            !empty($data->id)
        ) {
            // Atribuir o ID para exclusão
            $pokemon->id = $data->id; //é o que vem pelo json
            $pokemon->get();
 
            // Tentar excluir o pokemon
            if ($pokemon->delete() && $pokemon->nome) {
                http_response_code(200);
                // Resposta de sucesso    
                echo json_encode(
                    array('Mensagem' => 'Pokemon Excluído com Sucesso')
                );
            } else {
                http_response_code(404);
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Id inválido. Nao existe Pokemon com esse id.')
                );
            }
        } else {
            // Resposta se dados estiverem incompletos
            http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel excluir o Pokemon.')
            );
        }
    } catch (Exception $e) {        
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("erro" => "Método não suportado!"));
}