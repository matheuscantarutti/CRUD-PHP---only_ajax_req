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
        $total_preco = floatval(clear_input($_POST["total_preco"]));
        $total_qtd = intval(clear_input($_POST["total_qtd"]));
        $id_cliente = intval(clear_input($_POST["id_cliente"]));
        $data_venda =  date('Y-m-d H:i:s');

        $venda = new Venda($data_venda, $total_preco, $total_qtd, $id_cliente);

        $result = $venda->createVenda();
        
        if($result){
            echo "good.Venda efetuada com sucesso!";
        } 


        foreach ($produtos as $key => $produto) {
            $id_produto = clear_input($produto->produto);
            $qtd = clear_input($produto->qtd);
            $preco = clear_input($produto->preco);
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









