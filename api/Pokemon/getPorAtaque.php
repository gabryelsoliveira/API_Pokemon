<?php
 
//http://localhost/APIPOKEMON/api/pokemon/portreinador.php?idTreinador=2
 
 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../../Config/Database.php';
include_once '../../Models/Pokemon.php';
 
use API_Pokemon\Config\Database;
use API_Pokemon\Models\Pokemon;
 
$database = new Database();
$db = $database->getConnection();
 
$pokemon = new Pokemon($db);
 
$stmt = $pokemon->getPokemonsAtaque();
 
$pokemon = [];
 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);
 
    $pokemon[] = [
        "idPokemon" => $idPokemon,
        "nome" => $nome,
        "ataque" => $ataque
    ];
}
 
echo json_encode($pokemon);