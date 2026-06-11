<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
 
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios e se o ID foi fornecido
        if (
            !empty($data->id) &&
            !empty($data->nome) &&
            !empty($data->genero) &&
            !empty($data->idade) &&
            !empty($data->cidadeOrigem) &&
            !empty($data->regiao) &&
            !empty($data->insignias) 
        ){
            // Atribuir o ID para atualização
            
            // Atribuir os demais valores
            $treinador->id = $data->id; //é o que vem pelo json
            $treinador->nome = $data->nome;
            $treinador->genero = $data->genero;
            $treinador->idade = $data->idade;
            $treinador->cidadeOrigem = $data->cidadeOrigem;
            $treinador->regiao = $data->regiao;
            $treinador->insignias = $data->insignias;

            // Tentar atualizar o treinador
            if ($treinador->update()) {
                http_response_code(200);
                // Resposta de sucesso    
                echo json_encode(
                    array('Mensagem' => 'Treinador Atualizado com Sucesso')
                );
            } else {
                http_response_code(500);
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel atualizar o Treinador')
                );
            }
        } else {
            // Resposta se dados estiverem incompletos
            http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel atualizar o Treinador.')
            );
        }
    } catch (Exception $e) {        
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("erro" => "Método não suportado!"));
}