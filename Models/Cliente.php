<?php

namespace Models;

require_once "../Utils/autoloader.php";

Use Data\Db as Db;
use PDO;

    class Cliente {
        
        protected $id;
        protected $nome;
        protected $cpf;
        protected $email;

        public function __construct($nome, $cpf, $email)
        {
            $this->nome = $nome;
            $this->cpf = $cpf;
            $this->email = $email;
        }

        public function __get($property) {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }
        
        public function __set($property, $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        
            return $this;
        }

        public static function listaClientes(){
            $sql = "SELECT * FROM clientes";

            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute();

            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $clientes; 
        }

        public static function clientePorId($id_cliente){
            $sql = "SELECT * FROM clientes WHERE id = :id_cliente";
            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute(array('id_cliente' => $id_cliente));
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            return $cliente; 
        }

        public function createCliente(){
            $sql = "INSERT INTO clientes
            (nome,
            email,
            cpf)
            VALUES(:nome,:email,:cpf)";

            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('nome' => $this->nome, 'cpf' => $this->cpf, 'email' => $this->email));

            return $result;
        }

        public function updateCliente($id_cliente){
            $sql = "UPDATE 
                        clientes
                    SET
                        `nome` = :nome,
                        `email` = :email,
                        `cpf` = :cpf
                    WHERE 
                        `id` = :id_cliente";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('nome' => $this->nome, 
                                            'cpf' => $this->cpf, 
                                            'email' => $this->email, 
                                            'id_cliente' => $id_cliente));

            return $result;
        }

        public static function deletaCliente($id_cliente){
            $sql = "DELETE FROM `rbm_test`.`clientes`
                    WHERE id = :id_cliente";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('id_cliente' => $id_cliente));

            return $result;
            
        }

    }
