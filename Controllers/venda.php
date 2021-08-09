<?php
    namespace Controllers;

    require_once "../Utils/autoloader.php";
    require_once "../Utils/functions.php";
    
    Use Models\Venda as Venda;

    if($_POST["acao"] == "lista_vendas"){

        if($_POST["mode"] == "todos"){
            $vendas = Venda::listaVendas();
        }

        if($_POST["mode"] == "disponiveis"){
            $vendas = Venda::disponiveis();
        }

        echo json_encode($vendas);
    }
    
    if($_POST["acao"] == "salva_venda"){
        
        $produtos = json_decode($_POST["produtos"]);
        
        foreach ($produtos as $key => $produto) {
            
        }
        
       

        if($_POST['mode'] == "create"){
            
            $result = $venda->createVenda();
        
            $msg = "Venda cadastrado(a) com sucesso!";
        }
        
        if($_POST['mode'] == 'update'){

            $id_venda = clear_input($_POST["id_venda"]);
            
            $result = $venda->updateVenda($id_venda);
        
            $msg = "Cadastro alterado com sucesso!";

        }
        
        if($result){
            echo "good.$msg";
        } 
        
    }

    if($_POST['acao'] == "venda_por_id"){
        $id_venda = clear_input($_POST["id_venda"]);
        
        $venda = Venda::vendaPorId($id_venda);
        
        echo json_encode($venda);
    }
    
    if($_POST['acao'] == 'deleta_venda'){
        $id_venda = clear_input($_POST["id_venda"]);

        $result = Venda::deletaVenda($id_venda);

        $msg = "Cadastro deletado com sucesso.";

        if($result){
            echo "info.$msg";
        } 

    }









