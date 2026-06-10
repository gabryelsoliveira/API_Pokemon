<?php

namespace API_Pokemon\Models;
use PDO;
use Throwable;

class Pokemon{

public $id;
public $nome;
public $tipo;
public $ponto_forca;
public $ponto_velocidade;
public $ponto_vida;
public $fraqueza;
public $ponto_resistencia;
public $genero;
private $db;
private $tabela = "Pokemon";

public function __construct($db){
    $this->db = $db;
}

public function getall(){
    $query = "SELECT id, nome, tipo, ponto_forca, ponto_velocidade, ponto_vida, fraqueza, ponto_resistencia, genero FROM " . $this->tabela;

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt;
}

public function get(){

        $query = 'SELECT
                p.id,
                p.nome,
                p.tipo,
                p.ponto_forca,
                p.ponto_velocidade,
                p.ponto_vida
            FROM
                ' . $this->tabela . ' p
            WHERE
                p.id = ?    
            LIMIT 1';
 
        $stmt = $this->db->prepare($query);
 
        $stmt->bindParam(1, $this->id);
       
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        $this->nome = $row['nome'];
        $this->tipo = $row['tipo'];
        $this->ponto_forca = $row['ponto_forca'];
        $this->ponto_velocidade = $row['ponto_velocidade'];
        $this->ponto_vida = $row['ponto_vida'];
}
}