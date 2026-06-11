<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
 
include_once '../../Config/Database.php';
include_once '../../Models/Treinador.php';
 
use API_Pokemon\Config\Database;
use API_Pokemon\Models\Treinador;
 
// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Treinador
$treinador = new Treinador($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Obter os dados postados
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios
        if (
            !empty($data->nome) &&
            !empty($data->genero) &&
            !empty($data->idade) &&
            !empty($data->cidadeOrigem) &&
            !empty($data->regiao) &&
            !empty($data->insignias)
        ) {
            // Atribuir os valores ao objeto Treinador
            $treinador->nome = $data->nome;
            $treinador->genero = $data->genero;
            $treinador->idade = $data->idade;
            $treinador->cidadeOrigem = $data->cidadeOrigem;
            $treinador->regiao = $data->regiao;
            $treinador->insignias = $data->insignias;

            // Criar o treinador
            if ($treinador->add()) {
                http_response_code(201);
                // Resposta de sucesso
                echo json_encode(
                    array('Mensagem' => 'Treinador Criado com Sucesso')
                );
            } else {
                http_response_code(400);
                // Resposta de erro
                echo json_encode(
                    array('Erro' => 'Nao foi possivel criar o Treinador')
                );
            }
        } else {
            http_response_code(400);
            // Resposta se dados estiverem incompletos
            echo json_encode(
                array('Erro' => 'Dados Incompletos. Nao foi possivel criar o Treinador.')
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