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
            $sql = "SELECT 
                        v.*, c.nome 
                    from 
                        vendas v 
                        join clientes c on v.id_cliente = c.id";

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
            (`data_venda`,
            `preco`,
            `quantidade`,
            `id_cliente`)
        VALUES
            (:data_venda, 
            :preco,
            :quantidade,
            :id_cliente)";

            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('data_venda' => $this->data, 
                                            'preco' => $this->preco, 
                                            'id_cliente' => $this->cliente,
                                            'quantidade' => $this->quantidade));
            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
        }

        


    }