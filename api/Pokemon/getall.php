<?php

use API_Pokemon\Models\Pokemon;
use API_Pokemon\Config\Database;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';
 
$database = new Database();
$db = $database->getConnection();
 
$pokemon = new Pokemon($db);

try {
    $stmt = $pokemon->getall();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $pokemons_arr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $pokemon_item = array(
                "id" => $idPokemon,
                "nome" => $nome,
                "tipo" => $tipo,
                "fraqueza" => $fraqueza,
                "forca" => $forca,
                "velocidade" => $velocidade,
                "vida" => $vida,
                "resistencia" => $resistencia,
                "genero" => $genero,
                "idTreinador" => $idTreinador
            );
            array_push($pokemons_arr, $pokemon_item);
        }

        http_response_code(200);

        echo json_encode($pokemons_arr);

    } else {
        http_response_code(404);

        echo json_encode(
            array("Mensagem" => "Nenhum pokemon encontrado.")
        );
    }

} catch (PDOException $e) {
    echo json_encode(array("erro" => $e->getMessage()));
}
catch (Throwable $e) {
    echo json_encode(array("erro" => $e->getMessage()));
}