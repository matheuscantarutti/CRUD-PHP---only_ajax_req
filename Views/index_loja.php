<?php
    Namespace Views;
    require_once  "../Utils/autoloader.php";
    include_once "cabecalho.php";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Loja</title>
	</head>
	<body >
        <div class=" container ">
            <div id="carrinho">
                <h2>Carrinho</h2>
                <form action="" method="post" enctype="multipart/form" id="form_carrinho">
                    <div class="div_total">
                        <label for="">Total:</label>
                        <input type="text" name="total_qtd" id="total_qtd"  value="0" readonly>
                        <input type="text" name="total_preco" id="total_preco" value="0" readonly>
                        <button type="submit" class="btn btn-primary d-none" id="btn_venda">Finalizar venda</button>
                    </div>
                    <div class="labels_carrinho">
                        <label for="" class="m-5">Quantidade:</label>
                        <label for="" class="m-5">Produto:</label>
                        <label for="" class="m-5">Valor(R$):</label>
                        <input type="hidden" name="id_cliente" id="id_cliente">
                    </div>
                    <div id="divDetalhesVenda"></div>
                </form>
            </div>
            <div class="compra">
                <div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="alert-cadastro">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div id="div_clientes_loja" class="m-2">
                    <h2>
                        Produtos disponíveis
                    </h2>
                    <select name="select_clientes" id="select_clientes" class="m-2 float-end"></select>
			    </div>

			    <table class="table table-striped" id="tabela_produtos_disponiveis" >
				<thead>
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Preco</th>
						<th>Qtd em estoque</th>
						<th>Descricao</th>
                        <th>Qtd da venda</th>
					</tr>
				</thead>
				<tbody id="body-tabela-produto">
				</tbody>
			    </table>
            </div>
			
		</div>
		<script src="../Resources/js/ajaxProduto.js"></script>
		<script src="../Resources/js/ajaxCliente.js"></script>
		<script src="../Resources/js/ajaxVenda.js"></script>
		<script>
            window.onload = function(){
                listaClientes("loja");
            }

            var selectClientes = document.getElementById("select_clientes");
            selectClientes.addEventListener("change", function(){
                var idCliente = event.target.options[event.target.selectedIndex].value;
                inputClienteVenda = document.getElementById("id_cliente")
                inputClienteVenda.value = idCliente;
                listaProdutos("disponiveis");
            });

            var form = document.getElementById("form_carrinho");
            form.addEventListener("click", function(e){
                e.preventDefault();
                salvaVenda(form);
            });

            
		</script>
	</body>
</html>

