<?php

namespace API_Pokemon\Models;
use PDO;
use Throwable;

class Pokemon{

public $id;
public $nome;
public $tipo;
public $fraqueza;
public $forca;
public $velocidade;
public $vida;
public $resistencia;
public $genero;
public $idTreinador;
private $db;
private $tabela = "pokemon";

public function __construct($db){
    $this->db = $db;
}


public function get(){

        $query = 'SELECT
                p.idPokemon,
                p.nome,
                p.tipo,
                p.fraqueza,
                p.forca,
                p.velocidade,
                p.vida,
                p.resistencia,
                p.genero,
                p.idTreinador
            FROM
                ' . $this->tabela . ' p
            WHERE
                p.idPokemon = ?    
            LIMIT 1';
 
        $stmt = $this->db->prepare($query);
 
        $stmt->bindParam(1, $this->id);
       
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        $this->nome = $row['nome'];
        $this->tipo = $row['tipo'];
        $this->fraqueza = $row['fraqueza'];
        $this->forca = $row['forca'];
        $this->velocidade = $row['velocidade'];
        $this->vida = $row['vida'];
        $this->resistencia = $row['resistencia'];
        $this->genero = $row['genero'];
        $this->idTreinador = $row['idTreinador'];
}       
    public function getall(){
    $query = "SELECT idPokemon, nome, tipo, fraqueza, forca, velocidade, vida, resistencia, genero, idTreinador FROM " . $this->tabela;

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
}

public function add()
    {
        $query = 'INSERT INTO ' . $this->tabela . ' (nome, tipo, fraqueza, forca, velocidade, vida, resistencia, genero, idTreinador) ' .
            ' VALUES (:nome, :tipo, :fraqueza, :forca, :velocidade, :vida, :resistencia, :genero, :idTreinador)';

        // Preparar a query
        $stmt = $this->db->prepare($query);

        // Vincular os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':fraqueza', $this->fraqueza);
        $stmt->bindParam(':forca', $this->forca);
        $stmt->bindParam(':velocidade', $this->velocidade);
        $stmt->bindParam(':vida', $this->vida);
        $stmt->bindParam(':resistencia', $this->resistencia);
        $stmt->bindParam(':genero', $this->genero);
        $stmt->bindParam(':idTreinador', $this->idTreinador);
        // Executar a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

         public function update(){

     // Query de atualização
            $query = 'UPDATE ' . $this->tabela. ' SET nome=:nome, tipo=:tipo, fraqueza=:fraqueza, forca=:forca, velocidade=:velocidade, vida=:vida, resistencia=:resistencia, genero=:genero, idTreinador=:idTreinador WHERE idPokemon=:id';
   
            // Preparar a query
            $stmt = $this->db->prepare($query);
                 
            // Vincular os parâmetros
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':tipo', $this->tipo);
            $stmt->bindParam(':fraqueza', $this->fraqueza);
            $stmt->bindParam(':forca', $this->forca);
            $stmt->bindParam(':velocidade', $this->velocidade);
            $stmt->bindParam(':vida', $this->vida);
            $stmt->bindParam(':resistencia', $this->resistencia);
            $stmt->bindParam(':genero', $this->genero);
            $stmt->bindParam(':idTreinador', $this->idTreinador);
            $stmt->bindParam(':id', $this->id);
   
            // Executar a query
            if($stmt->execute()) {
                return true;
            }
         
            return false;

    }
    public function delete(){
        // Query de exclusão
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE idPokemon = :id';
 
        // Preparar a query
        $stmt = $this->db->prepare($query);
 
        // Vincular o ID
        $stmt->bindParam(':id', $this->id);
 
        // Executar a query
        if ($stmt->execute()) {
            return true;
        }
         
        return false;
    }

    public function getTreinador(){  //VAI NO BANCO DE DADOS E TRAZ O TREINADOR ASSOCIADO A POKEMON COM O ID ESPECIFICADO
    $query = 'SELECT
    t.idTreinador,
    t.nome AS Treinador
    FROM treinador t
    WHERE t.idTreinador = :id';
 
        $stmt = $this->db->prepare($query);
 
        $this->idTreinador=htmlspecialchars(strip_tags($this->idTreinador));
 
        $stmt->bindParam(':id', $this->idTreinador);
 
        $stmt->execute();
 
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
    public function getPokemonsTreinador(){
 
    $query = "SELECT
        numPokedex,
        nome
        FROM pokemon
        WHERE idTreinador = :id";
 
    $stmt = $this->db->prepare($query);
 
    $stmt->bindParam(':id', $this->idTreinador);
 
    $stmt->execute();
 
    return $stmt;
 
    }

    public function getPokemonsVelozes(){
 
    $query = "SELECT
        idPokemon,
        numPokedex,
        nome,
        velocidade
        FROM pokemon
        order by velocidade DESC
        limit 5";
 
    $stmt = $this->db->prepare($query);
    $stmt->execute();
 
    return $stmt;
 
    }

    public function getPokemonsAtaque(){
        $query = "SELECT
            idPokemon,
            numPokedex,
            nome,
            ataque
            FROM pokemon
            order by ataque DESC
            limit 5";
 
        $stmt = $this->db->prepare($query);
        $stmt->execute();
 
        return $stmt;
 
    }
    public function getPokemonsDefesa(){
        $query = "SELECT
            idPokemon,
            numPokedex,
            nome,
            defesa
            FROM pokemon
            order by defesa DESC
            limit 5";
 
        $stmt = $this->db->prepare($query);
        $stmt->execute();
 
        return $stmt;
 
    }
}
