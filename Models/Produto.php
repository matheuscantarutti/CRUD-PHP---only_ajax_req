<?php


namespace Models;

require_once "../Utils/autoloader.php";

Use Data\Db as Db;
use PDO;

    class Produto{

        protected $id;
        protected $nome;
        protected $preco;
        protected $quantidade;
        protected $descricao;
        


        public function __construct($nome, $preco, $quantidade, $descricao)
        {
            $this->nome = $nome;
            $this->preco = $preco;
            $this->quantidade = $quantidade;
            $this->descricao = $descricao;
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

        public static function listaProdutos(){
            $sql = "SELECT * FROM produtos";

            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute();

            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $produtos; 
        }

        public static function disponiveis(){
            $sql = "SELECT * FROM produtos WHERE quantidade > 0";

            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute();

            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $produtos; 
        }



        public static function produtoPorId($id_produto){
            $sql = "SELECT * FROM produtos WHERE id = :id_produto";
            $stmt = Db::getConn()->prepare($sql);
            $stmt->execute(array('id_produto' => $id_produto));
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            return $produto; 
        }

        public function createProduto(){
            $sql = "INSERT INTO `rbm_test`.`produtos`
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

        public function updateProduto($id_produto){
            $sql = "UPDATE `rbm_test`.`produtos`
                    SET
                        `nome` = :nome,
                        `preco` = :preco,
                        `descricao` = :descricao,
                        `quantidade` = :quantidade
                    WHERE 
                        `id` = :id_produto";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('nome' => $this->nome, 
                                            'preco' => $this->preco, 
                                            'descricao' => $this->descricao,
                                            'quantidade' => $this->quantidade,
                                            'id_produto' => $id_produto));

            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
        }

        public static function updateProdutoEstoque($id_produto, $qtd_venda){
            $sql = "UPDATE `rbm_test`.`produtos`
                    SET
                        `quantidade` = (quantidade - :qtd_venda)
                    WHERE 
                        `id` = :id_produto";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('qtd_venda' => $qtd_venda,
                                            'id_produto' => $id_produto));

            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
        }

        public static function deletaProduto($id_produto){
            $sql = "DELETE FROM `rbm_test`.`produtos`
                    WHERE id = :id_produto";
            
            $stmt = Db::getConn()->prepare($sql);

            $result = $stmt->execute(array('id_produto' => $id_produto));

            if($result){
                return $result;
            } else {
                echo "bad.".$stmt->errorInfo()[2];
            }
            
        }

    }