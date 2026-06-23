<?php

namespace API_Pokemon\Models;
use PDO;

class Treinador
{
    public $id;
    public $nome;
    public $genero;
    public $idade;
    public $cidadeOrigem;
    public $regiao;
    public $insignias;

    private $db;
    private $tabela = "Treinador";

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function get()
    {
        $query = "SELECT
                    idTreinador,
                    nome,
                    genero,
                    idade,
                    cidadeOrigem,
                    regiao,
                    insignias
                  FROM " . $this->tabela . "
                  WHERE idTreinador = ?
                  LIMIT 1";
                  
                  $stmt = $this->db->prepare($query);
                  
                  $stmt->bindParam(1, $this->id);
                  
                  $stmt->execute();
                  
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  
                  if ($row) {
                      $this->nome = $row['nome'];
                      $this->genero = $row['genero'];
                      $this->idade = $row['idade'];
                      $this->cidadeOrigem = $row['cidadeOrigem'];
                      $this->regiao = $row['regiao'];
                      $this->insignias = $row['insignias'];
                      }
                      }
                    

    public function getall()
    {
        $query = "SELECT
                    idTreinador,
                    nome,
                    genero,
                    idade,
                    cidadeOrigem,
                    regiao,
                    insignias
                  FROM " . $this->tabela;

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }
                          
public function add()
    {
        $query = 'INSERT INTO ' . $this->tabela . ' (idTreinador, nome, genero, idade, cidadeOrigem, regiao, insignias) ' .
            ' VALUES (:id, :nome, :genero, :idade, :cidadeOrigem, :regiao, :insignias)';

        // Preparar a query
        $stmt = $this->db->prepare($query);

        // Vincular os parâmetros
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':genero', $this->genero);
        $stmt->bindParam(':idade', $this->idade);
        $stmt->bindParam(':cidadeOrigem', $this->cidadeOrigem);
        $stmt->bindParam(':regiao', $this->regiao);
        $stmt->bindParam(':insignias', $this->insignias);

        // Executar a query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

         public function update(){

     // Query de atualização
            $query = 'UPDATE ' . $this->tabela. ' SET nome=:nome, genero=:genero, idade=:idade, cidadeOrigem=:cidadeOrigem, regiao=:regiao, insignias=:insignias WHERE idTreinador=:id';
   
            // Preparar a query
            $stmt = $this->db->prepare($query);
                 
            // Vincular os parâmetros
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':genero', $this->genero);
            $stmt->bindParam(':idade', $this->idade);
            $stmt->bindParam(':cidadeOrigem', $this->cidadeOrigem);
            $stmt->bindParam(':regiao', $this->regiao);
            $stmt->bindParam(':insignias', $this->insignias);
            $stmt->bindParam(':id', $this->id);
   
            // Executar a query
            if($stmt->execute()) {
                return true;
            }
         
            return false;

    }
        public function delete(){
        // Query de exclusão
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE idTreinador = :id';
 
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
}