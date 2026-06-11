<?php

use API_Pokemon\Models\Treinador;
use API_Pokemon\Config\Database;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../../Config/Database.php';
include_once '../../Models/Treinador.php';
 
$database = new Database();
$db = $database->getConnection();
 
$treinador = new Treinador($db);

try {
    $stmt = $treinador->getall();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $treinadores_arr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $treinador_item = array(
                "id" => $idTreinador,
                "nome" => $nome,
                "genero" => $genero,
                "idade" => $idade,
                "cidadeOrigem" => $cidadeOrigem,
                "regiao" => $regiao,
                "insignias" => $insignias
            );
            array_push($treinadores_arr, $treinador_item);
        }

        http_response_code(200);

        echo json_encode($treinadores_arr);

              {
            array_push($treinadores_arr, $treinador_item);
        }

        http_response_code(200);

        echo json_encode($treinadores_arr);

    } else {
        http_response_code(404);

        echo json_encode(
            array("Mensagem" => "Nenhum treinador encontrado.")
        );
    }

} catch (PDOException $e) {
    echo json_encode(array("erro" => $e->getMessage()));
}
catch (Throwable $e) {
    echo json_encode(array("erro" => $e->getMessage()));
}