<?php
    namespace Controllers;

    require_once "../Utils/autoloader.php";
    require_once "../Utils/functions.php";
    
    Use Models\Cliente as Cliente;

    if($_POST["acao"] == "lista_clientes"){
        
        $clientes = Cliente::listaClientes();

        echo json_encode($clientes);
    }
    
    if($_POST["acao"] == "salva_cliente"){
        
        $nome = clear_input($_POST["nome"]);
        $cpf = clear_input($_POST["cpf"]);
        $email = clear_input($_POST["email"]);

        if($_POST['mode'] == "create"){
            
            $cliente = new Cliente($nome, $cpf, $email);
            
            $result = $cliente->createCliente();
        
            $msg = "Cliente cadastrado(a) com sucesso!";
        }
        
        if($_POST['mode'] == 'update'){

            $id_cliente = clear_input($_POST["id_cliente"]);
            $cliente = new Cliente($nome, $cpf, $email);
            
            $result = $cliente->updateCliente($id_cliente);
        
            $msg = "Cadastro alterado com sucesso!";

        }
        
        if($result){
            echo "good.$msg";
        } else {
            echo "bad.".$result->errorInfo()[2];
        }
    }

    if($_POST['acao'] == "cliente_por_id"){
        $id_cliente = clear_input($_POST["id_cliente"]);
        
        $cliente = Cliente::clientePorId($id_cliente);
        
        echo json_encode($cliente);
    }
    
    if($_POST['acao'] == 'deleta_cliente'){
        $id_cliente = clear_input($_POST["id_cliente"]);

        $result = Cliente::deletaCliente($id_cliente);

        $msg = "Cadastro deletado com sucesso.";

        if($result){
            echo "info.$msg";
        } else {
            echo "bad.".$result->errorInfo()[2];
        }

    }









