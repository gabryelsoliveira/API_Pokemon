<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../Config/Database.php';
include_once '../../Models/Treinador.php';
 
use API_Pokemon\Config\Database;
use API_Pokemon\Models\Treinador;  
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Treinador
$treinador = new Treinador($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios e se o ID foi fornecido
        if (
            !empty($data->id)
        ) {
            // Atribuir o ID para exclusão
            $treinador->id = $data->id; //é o que vem pelo json
            $treinador->get();
 
            // Tentar excluir o treinador
            if ($treinador->delete() && $treinador->nome) {
                http_response_code(200);
                // Resposta de sucesso    
                echo json_encode(
                    array('Mensagem' => 'Treinador Excluído com Sucesso')
                );
            } else {
                http_response_code(404);
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Id inválido. Nao existe Treinador com esse id.')
                );
            }
        } else {
            // Resposta se dados estiverem incompletos
            http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel excluir o Treinador.')
            );
        }
    } catch (Exception $e) {        
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("erro" => "Método não suportado!"));
}