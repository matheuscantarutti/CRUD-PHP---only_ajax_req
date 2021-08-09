<?php


namespace Models;

require_once "../Utils/autoloader.php";

Use Data\Db as Db;
use PDO;

    class Venda{

        protected $id;
        protected $data;
        protected $preco;
        protected $quantidade;
        protected $cliente;


        public function __construct($data, $preco, $quantidade, $cliente)
        {
            $this->data = $data;
            $this->preco = $preco;
            $this->quantidade = $quantidade;
            $this->cliente = $cliente;
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

        public static function listaVendas(){
            $sql = "SELECT * FROM vendas";

            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute();

            $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $vendas; 
        }

        public static function disponiveis(){
            $sql = "SELECT * FROM vendas WHERE quantidade > 0";

            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute();

            $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $vendas; 
        }



        public static function vendaPorId($id_venda){
            $sql = "SELECT * FROM vendas WHERE id = :id_venda";
            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute(array('id_venda' => $id_venda));
            $venda = $stmt->fetch(PDO::FETCH_ASSOC);
            return $venda; 
        }

        public function createVenda(){
            $sql = "INSERT INTO `rbm_test`.`vendas`
                        (`nome`,
                        `preco`,
                        `descricao`,
                        `quantidade`)
                    VALUES
                        (:nome,
                        :preco,
                        :descricao,
                        :quantidade)";

            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('nome' => $this->nome, 
                                            'preco' => $this->preco, 
                                            'descricao' => $this->descricao,
                                            'quantidade' => $this->quantidade));
            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
        }

        public function updateVenda($id_venda){
            $sql = "UPDATE `rbm_test`.`vendas`
                    SET
                        `nome` = :nome,
                        `preco` = :preco,
                        `descricao` = :descricao,
                        `quantidade` = :quantidade
                    WHERE 
                        `id` = :id_venda";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('nome' => $this->nome, 
                                            'preco' => $this->preco, 
                                            'descricao' => $this->descricao,
                                            'quantidade' => $this->quantidade,
                                            'id_venda' => $id_venda));

            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
        }

        public static function deletaVenda($id_venda){
            $sql = "DELETE FROM `rbm_test`.`vendas`
                    WHERE id = :id_venda";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('id_venda' => $id_venda));

            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
            
        }

    }