<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
 
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';
 
use API_Pokemon\Config\Database;
use API_Pokemon\Models\Pokemon;
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pokemon
$pokemon = new Pokemon($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        if (
            !empty($data->nome) &&
            !empty($data->tipo) &&
            !empty($data->fraqueza) &&
            !empty($data->forca) &&
            !empty($data->velocidade) &&
            !empty($data->vida) &&
            !empty($data->resistencia) &&
            !empty($data->genero) &&
            !empty($data->idTreinador)
        ) 
       
        {
            // Atribuir os valores ao objeto Pokemon
            $pokemon->nome = $data->nome;
            $pokemon->tipo = $data->tipo;
            $pokemon->fraqueza = $data->fraqueza;
            $pokemon->forca = $data->forca;
            $pokemon->velocidade = $data->velocidade;
            $pokemon->vida = $data->vida;
            $pokemon->resistencia = $data->resistencia;
            $pokemon->genero = $data->genero;
            $pokemon->idTreinador = $data->idTreinador;

            // Criar o pokemon
            if ($pokemon->add()) {
                http_response_code(201);
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Pokemon Criado com Sucesso')
                );
            } else {
                http_response_code(400);
                // Resposta de erro
                echo json_encode(
                    array('Erro' => 'Nao foi possivel criar o Pokemon')
                );
            }
        } else {
            http_response_code(400);
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel criar o Pokemon.')
            );
        }
    } catch (Exception $e) {
        echo json_encode(array("Erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("Erro" => "Método não suportado!"));
}
?>