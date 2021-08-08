<?php
    Namespace Views;
    require_once  "../Utils/autoloader.php";
    include_once "cabecalho.php";
    $id_cliente = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Clientes</title>
    </head>
    <body>
        <div class="p-5 container">
            <div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="alert-cadastro">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <h1>Cadastro de Clientes</h1>
            <form id="cadastro-form" action="#" method="post" enctype="multipart/form">
            <input type="hidden" name="id_cliente" id="id_cliente" value="<?=$id_cliente?>">
                <div class="form-group m-3">
                    <label for="nome">Nome</label>
                    <input type="name" name="nome" class="form-control" id="nome" placeholder="Nome" required >
                </div>
                <div class="form-group m-3">
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" class="form-control" id="cpf" placeholder="Apenas Números" required>
                </div>
                <div class="form-group m-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required>
                </div> 
                <button type="submit" id="btn-submit" name="salva_cliente" value="create" class="btn btn-success m-3">Salvar</button>
            </form>
        </div>
        <script src="../Resources/js/ajaxCliente.js"></script>
		<script>
            window.onload = function() {
                var idCliente = document.getElementById("id_cliente")

                if(idCliente.value != 0){
                    clientePorId(idCliente.value)
                }
            }

            var form = document.getElementById("cadastro-form")
            form.addEventListener("submit", function(event){
                event.preventDefault();
                salvaCadastro(event.target);
            });
        </script>
    </body>
</html>