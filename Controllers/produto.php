<?php
    namespace Controllers;

    require_once "../Utils/autoloader.php";
    require_once "../Utils/functions.php";
    
    Use Models\Produto as Produto;

    if($_POST["acao"] == "lista_produtos"){

        if($_POST["mode"] == "todos"){
            $produtos = Produto::listaProdutos();
        }

        if($_POST["mode"] == "disponiveis"){
            $produtos = Produto::disponiveis();
        }

        echo json_encode($produtos);
    }
    
    if($_POST["acao"] == "salva_produto"){

        
        
        $nome = clear_input($_POST["nome"]);
        $descricao = clear_input($_POST["descricao"]);
        $preco = floatval(clear_input($_POST["preco"]));
        $quantidade = clear_input($_POST["quantidade"]);

        $produto = new Produto($nome, $preco, $quantidade, $descricao);

        if($_POST['mode'] == "create"){
            
            $result = $produto->createProduto();
        
            $msg = "Produto cadastrado(a) com sucesso!";
        }
        
        if($_POST['mode'] == 'update'){

            $id_produto = clear_input($_POST["id_produto"]);
            
            $result = $produto->updateProduto($id_produto);
        
            $msg = "Cadastro alterado com sucesso!";

        }
        
        if($result){
            echo "good.$msg";
        } 
        
    }

    if($_POST['acao'] == "produto_por_id"){
        $id_produto = clear_input($_POST["id_produto"]);
        
        $produto = Produto::produtoPorId($id_produto);
        
        echo json_encode($produto);
    }
    
    if($_POST['acao'] == 'deleta_produto'){
        $id_produto = clear_input($_POST["id_produto"]);

        $result = Produto::deletaProduto($id_produto);

        $msg = "Cadastro deletado com sucesso.";

        if($result){
            echo "info.$msg";
        } 

    }









