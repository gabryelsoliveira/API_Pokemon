<?php

namespace API_Pizzaria\Config;
use PDO;
use PDOException;
use Throwable;

class Database
{

    //nome ou ip do server
    private $host = "localhost";
    //porta
    private $port = "3311";
    //nome do banco de dados
    private $db_name = "api_pokemon";
    //login
    private $user_name = "root";
    //senha
    private $password = "usbw";
    //conexão
    private $conn;

    // Método para obter a conexão com o banco de dados
    public function getConnection()
    {
        $this->conn = null;

        try {
            // DSN (Data Source Name) - String de conexão
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';
            // Instancia o objeto PDO
            $this->conn = new PDO($dsn, $this->user_name, $this->password);
            // Define o modo de erro do PDO para exceção
            // Isso faz com que o PDO lance exceções em caso de erros, facilitando o tratamento
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Em caso de erro na conexão, exibe a mensagem de erro
            echo 'Erro de Conexão: ' . $e->getMessage();
        }

        return $this->conn;
    }
}

?>