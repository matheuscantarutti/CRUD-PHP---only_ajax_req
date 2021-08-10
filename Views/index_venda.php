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
		<title>Vendas</title>
	</head>
	<body >
		<div class="p-5 container">
			<div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="alert-cadastro">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
			<div >
				<a href="cadastro_venda.php" class="btn btn-primary float-start">
					Relatório vendas
				</a>
				<a href="cadastro_venda.php" class="btn btn-success float-end">
					Realizar Venda
				</a>
				<h2></h2>
				<div class="clearfix"></div>
			</div>

			<table class="table table-striped" >
				<thead>
					<tr>
						<th>#</th>
						<th>Cliente</th>
						<th>Valor Total</th>
						<th>Quantidade</th>
						<th>Data / Hora</th>
					</tr>
				</thead>
				<tbody id="body-tabela-venda">
					
				</tbody>
			</table>
		</div>
		<script src="../Resources/js/ajaxVenda.js"></script>
		<script>
			window.onload = function(){
				listaVendas("todos");
			}
		</script>
	</body>
</html>

