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
		<title>Produtos</title>
	</head>
	<body >
	<h1 class="text-center">Produtos</h1>
		<div class="p-5 container">
			<div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="alert-cadastro">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
			<div class="div_btn_index">
				<a href="../Utils/relatorio_pdf.php?model=produto" class="btn btn-primary float-start">
					Relatório produtos
				</a>
				<a href="cadastro_produto.php" class="btn btn-success float-end">
					Cadastrar Produto
				</a>
				<h2></h2>
				<div class="clearfix"></div>
			</div>
			<div class="twrap">
				<table class="table table-striped" >
					<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>Preco</th>
							<th>Qtd em estoque</th>
							<th>Descricao</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody id="body-tabela-produto">
						
					</tbody>
				</table>
			</div>
		</div>
		<script src="../Resources/js/ajaxProduto.js"></script>
		<script>
			window.onload = function(){
				listaProdutos("todos");
			}
		</script>
	</body>
</html>

