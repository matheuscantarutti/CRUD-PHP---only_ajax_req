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
		<title>Clientes</title>
	</head>
	<body >
		<h1 class="text-center">Clientes</h1>
		<div class="p-5 container">
			<div class="alert alert-success d-none alert-dismissible fade show" role="alert" id="alert-cadastro">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
			<div class="div_btn_index">
				<a href="../Utils/relatorio_pdf.php?model=cliente" class="btn btn-primary float-start">
					Relatório Clientes
				</a>
				<a href="cadastro_cliente.php" class="btn btn-success float-end">
					Cadastrar Cliente
				</a>
			</div>
			<div class="twrap">

				<table class="table table-striped" >
					<thead>
						<tr>
							<th>#</th>
							<th>Nome</th>
							<th>E-mail</th>
							<th>CPF</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody id="body-tabela-cliente">
						
					</tbody>
				</table>
			</div>
		</div>
		<script src="../Resources/js/ajaxCliente.js"></script>
		
		<script>
			window.onload = function(){
				listaClientes("index");
			}

		</script>
	</body>
</html>

