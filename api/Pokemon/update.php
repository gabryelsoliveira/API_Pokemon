<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
 
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios e se o ID foi fornecido
        if (
            !empty($data->id) &&
            !empty($data->nome) &&
            !empty($data->tipo) &&
            !empty($data->fraqueza) &&
            !empty($data->forca) &&
            !empty($data->velocidade) &&
            !empty($data->vida) &&
            !empty($data->resistencia) &&
            !empty($data->genero) &&
            !empty($data->idTreinador)
        ){
            // Atribuir o ID para atualização
            $pokemon->id = $data->id; //é o que vem pelo json
 
            // Atribuir os demais valores
            $pokemon->nome = $data->nome;
            $pokemon->tipo = $data->tipo;
            $pokemon->fraqueza = $data->fraqueza;
            $pokemon->forca = $data->forca;
            $pokemon->velocidade = $data->velocidade;
            $pokemon->vida = $data->vida;
            $pokemon->resistencia = $data->resistencia;
            $pokemon->genero = $data->genero;
            $pokemon->idTreinador = $data->idTreinador;

            // Tentar atualizar o pokemon
            if ($pokemon->update()) {
                http_response_code(200);
                // Resposta de sucesso    
                echo json_encode(
                    array('Mensagem' => 'Pokemon Atualizado com Sucesso')
                );
            } else {
                http_response_code(500);
                // Resposta de erro
                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel atualizar o Pokemon')
                );
            }
        } else {
            // Resposta se dados estiverem incompletos
            http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel atualizar o Pokemon.')
            );
        }
    } catch (Exception $e) {        
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("erro" => "Método não suportado!"));
}