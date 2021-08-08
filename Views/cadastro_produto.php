<?php
    Namespace Views;
    require_once  "../Utils/autoloader.php";
    include_once "cabecalho.php";
    $id_produto = isset($_GET['id_produto']) ? $_GET['id_produto'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Produtos</title>
    </head>
    <body>
        <div class="p-5 container">
            <div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="alert-cadastro">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <h1>Cadastro de Produtos</h1>
            <form id="cadastro-form" action="#" method="post" enctype="multipart/form">
            <input type="hidden" name="id_produto" id="id_produto" value="<?=$id_produto?>">
                <div class="form-group m-3">
                    <label for="nome">Nome</label>
                    <input type="name" class="form-control" id="nome" placeholder="Nome" required >
                </div>
                <div class="form-group m-3">
                    <label for="descricao">Descrição:</label>
                    <input type="text" class="form-control" id="descricao" placeholder="Descrição do produto" required>
                </div>
                <div class="form-group m-3">
                    <label for="preco">Preço(R$):</label>
                    <input type="text" class="form-control" id="preco" placeholder="Preço" required>
                </div> 
                <div class="form-group m-3">
                    <label for="quantidade">Quantidade</label>
                    <input type="number" class="form-control" id="quantidade" placeholder="Quantidade" required>
                </div> 
                <button type="submit" id="btn-submit" name="salva_produto" value="create" class="btn btn-success m-3">Salvar</button>
            </form>
        </div>
        <script src="../Resources/js/ajaxProduto.js"></script>
		<script>
            window.onload = function() {
                var idProduto = document.getElementById("id_produto")

                if(idProduto.value != 0){
                    produtoPorId(idProduto.value)
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