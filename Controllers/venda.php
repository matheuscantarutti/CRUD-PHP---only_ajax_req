<?php
    namespace Controllers;

    require_once "../Utils/autoloader.php";
    require_once "../Utils/functions.php";
    
    Use Models\Venda as Venda;
    Use Models\Produto as Produto;
    

    if($_POST["acao"] == "lista_vendas"){
        
        $vendas = Venda::listaVendas();

        echo json_encode($vendas);
    }
    
    if($_POST["acao"] == "salva_venda"){
        
        $produtos = json_decode($_POST["produtos"]);
        $total_preco = floatval(clear_input($_POST["total_preco"]));
        $total_qtd = intval(clear_input($_POST["total_qtd"]));
        $id_cliente = intval(clear_input($_POST["id_cliente"]));
        date_default_timezone_set('America/Sao_Paulo');
        $data_venda =  date('Y/m/d H:i:s');
        var_dump($data_venda);

        $venda = new Venda($data_venda, $total_preco, $total_qtd, $id_cliente);

        $result = $venda->createVenda();
        
        if($result){
            foreach ($produtos as $key => $produto) {
                $id_produto = clear_input($produto->produto);
                $qtd = clear_input($produto->qtd);

                $atualizaEstoque = Produto::updateProdutoEstoque($id_produto, $qtd);
            }

            echo "good.Venda efetuada com sucesso!";
        } 

        
        
    }

    if($_POST['acao'] == "venda_por_id"){
        $id_venda = clear_input($_POST["id_venda"]);
        
        $venda = Venda::vendaPorId($id_venda);
        
        echo json_encode($venda);
    }
    










