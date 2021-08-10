var httpRequest;

if (window.XMLHttpRequest) { 
    httpRequest = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
}

function listaProdutos(tipo){
    data = "";
    if(tipo == "todos"){
        data = `acao=lista_produtos&mode=${tipo}`
    }

    if(tipo == "disponiveis"){
        data = `acao=lista_produtos&mode=${tipo}`
    }

	httpRequest.onreadystatechange = function(){
        
        if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
                var response = JSON.parse(httpRequest.responseText);
				preencheTabelaProdutos(response, tipo)
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/produto.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(data);
}


function preencheTabelaProdutos(lista_objetos, tipo){
    
    var bodyTabela = document.getElementById("body-tabela-produto");

    while(bodyTabela.firstChild){
        bodyTabela.removeChild(bodyTabela.firstChild);
    }

    if (lista_objetos.length == 0){
        var linha = document.createElement("tr");
        var dataVazio = document.createElement("td");
        dataVazio.innerHTML = "Nenhum(a) produto cadastrado(a)"
        dataVazio.setAttribute("colspan", "5")
        dataVazio.classList.add("text-center")
        linha.appendChild(dataVazio);
        bodyTabela.appendChild(linha);

    } else {
        lista_objetos.forEach(element => {
            var linha = document.createElement("tr");
            linha.setAttribute("id", `tr_${element.id}`);
            var dataNome = document.createElement("td");
            dataNome.innerHTML = element.nome
            var dataId = document.createElement("td")        ;
            dataId.innerHTML = element.id;
            var dataPreco = document.createElement("td");
            dataPreco.innerHTML = element.preco
            var dataDescricao = document.createElement("td");
            dataDescricao.innerHTML = element.descricao
            var dataQuantidade = document.createElement("td");
            dataQuantidade.innerHTML = element.quantidade
            linha.appendChild(dataId);
            linha.appendChild(dataNome);
            linha.appendChild(dataPreco);
            linha.appendChild(dataQuantidade);
            linha.appendChild(dataDescricao);
            
            var dataAcoes; 
            if(tipo == "todos"){
                dataAcoes = colunaAcoes(element.id);
            }
            
            if(tipo == "disponiveis"){
                dataAcoes = colunaCarrinho(element.id);
            }

            linha.appendChild(dataAcoes);
    
            bodyTabela.appendChild(linha);
        });
    }
}

function calculaTotal(preco_produto, qtdVenda, acao){
    var inputTotalPreco = document.getElementById("total_preco");
    var inputTotalQtd = document.getElementById("total_qtd");

    var precoTotal = parseFloat(inputTotalPreco.value)
    var qtdTotal = parseInt(inputTotalQtd.value)
    
    if(acao == "somar"){
        novoTotal = precoTotal + parseFloat(preco_produto)
        novaQtd = qtdTotal + qtdVenda
        
    }

    if(acao == "subtrair"){
        
        novoTotal = precoTotal - parseFloat(preco_produto)
        novaQtd = qtdTotal - qtdVenda
    }
    
    inputTotalPreco.value = novoTotal.toFixed(2)
    inputTotalQtd.value =novaQtd 
}



function addCarrinho(btn){
    var tr = btn.closest('tr');
    id_produto = tr.children[0].textContent;
    nome_produto = tr.children[1].textContent;
    preco_produto = parseFloat(tr.children[2].textContent);
    qtdVenda = parseInt(btn.previousElementSibling.value);
    preco_venda = preco_produto * qtdVenda;
    tdEstoque = tr.children[3];
    qtdEstoque = parseInt(tdEstoque.textContent);
    
    tdEstoque.textContent = qtdEstoque - qtdVenda;

    var inputProdutoVenda = document.createElement("input");
    var inputNomeProduto = document.createElement("input");
    var inputQtdVenda = document.createElement("input");
    var inputPrecoVenda = document.createElement("input");
    var divVenda = document.createElement("div");

    var formCarrinho = document.getElementById("form_carrinho");
    var btnApagar = document.createElement("button");

    btnApagar.classList.add("m-1");
    btnApagar.classList.add("btn");
    btnApagar.classList.add("btn-sm");
    btnApagar.classList.add("btn-danger");
    btnApagar.innerHTML = "Retirar Produto"
    btnApagar.type="button";
    
    inputProdutoVenda.value = id_produto;
    inputPrecoVenda.value = preco_venda.toFixed(2);
    inputQtdVenda.value = qtdVenda
    inputNomeProduto.value = nome_produto
    
    inputProdutoVenda.type = "hidden"
    
    inputProdutoVenda.classList.add("m-1")
    inputPrecoVenda .classList.add("m-1")
    inputQtdVenda.classList.add("m-1")
    inputNomeProduto.classList.add("m-1")
    
    inputProdutoVenda.setAttribute("readonly", "true")
    inputProdutoVenda.name = "produto_"+id_produto;
    inputPrecoVenda .setAttribute("readonly", "true")
    inputPrecoVenda.name = `preco_${id_produto}`
    inputQtdVenda.setAttribute("readonly", "true")
    inputQtdVenda.name = `qtd_${id_produto}`
    inputNomeProduto.setAttribute("readonly", "true")
    inputNomeProduto.name = `nome_${id_produto}`
    
    divVenda.appendChild(inputProdutoVenda);
    divVenda.appendChild(inputQtdVenda)
    divVenda.appendChild(inputNomeProduto);
    divVenda.appendChild(inputPrecoVenda)
    divVenda.appendChild(btnApagar)
    
    formCarrinho.appendChild(divVenda);
    
    btnApagar.addEventListener("click", function(e) {
        e.preventDefault();
        var idProduto = (e.target.parentNode.firstChild.value)
        var preco = parseFloat(e.target.parentNode.lastChild.previousElementSibling.value);
        var qtd = parseInt(e.target.parentNode.firstChild.nextElementSibling.value);
        calculaTotal(preco.toFixed(2), qtd, "subtrair");
        var tr = document.getElementById(`tr_${idProduto}`);
        var qtdEstoque = parseInt(tr.children[3].textContent);
        var novaQtdEstoque = qtdEstoque + qtd;
        tr.children[3].textContent = novaQtdEstoque
        divVenda.remove();
    });

    calculaTotal(preco_venda.toFixed(2), qtdVenda,  "somar");

    var divDetalhesVenda = document.getElementById("divDetalhesVenda");
    divDetalhesVenda.appendChild(divVenda);

    var btnVenda = document.getElementById("btn_venda");
    btnVenda.classList.remove("d-none");
}


function colunaCarrinho(idProduto){
    var dataAcoes = document.createElement("td");
    var btn = document.createElement("button")
    btn.innerHTML = "Adicionar ao Carrinho"
    btn.type="button"
    btn.classList.add("m-1");
    btn.classList.add("btn");
    btn.classList.add("btn-sm");
    btn.classList.add("btn-success");
    btn.setAttribute("data-id", idProduto);
    btn.classList.add("addCarrinho");
    
    var inputQtdVenda = document.createElement("input");
    inputQtdVenda.type = "number";
    inputQtdVenda.classList.add("w-25")
    inputQtdVenda.classList.add("inputQtdVenda");
    
    var div = document.createElement("div");
    div.classList.add("btn-group")
    div.appendChild(inputQtdVenda)
    div.appendChild(btn)
    dataAcoes.appendChild(div);
    
    btn.addEventListener("click", function(){
        if(inputQtdVenda.value <= 0){
            alert("Adicione a quantidade.")
            inputQtdVenda.focus();
        } 
        if(inputQtdVenda.value > 0){
            addCarrinho(btn)
        }
    });
    return dataAcoes;
}

function colunaAcoes(idProduto){
    var dataAcoes = document.createElement("td");
    var div = document.createElement("div");
    div.classList.add("btn-group")

    var a = document.createElement("a")
    a.innerHTML = "Editar"
    a.classList.add("m-1");
    a.classList.add("btn");
    a.classList.add("btn-sm");
    a.classList.add("btn-primary");
    a.href = `cadastro_produto.php?id_produto=${idProduto}`;
    
    var btn = document.createElement("button")
    btn.innerHTML = "Apagar"
    btn.type="button"
    btn.classList.add("m-1");
    btn.classList.add("btn");
    btn.classList.add("btn-sm");
    btn.classList.add("btn-danger");
    btn.addEventListener("click", function() {
        deletaProduto(idProduto);
    });

    div.appendChild(a)
    div.appendChild(btn)
    dataAcoes.appendChild(div);

    return dataAcoes;

}

function salvaCadastro(form){
    
    var nome = form.nome.value;
    var preco = form.preco.value;
    var descricao = form.descricao.value;
    var quantidade = form.quantidade.value;
    var data = "";
    
    if(form.salva_produto.value == "update"){
        var id_produto = form.id_produto.value;
        data = `acao=salva_produto&nome=${nome}&preco=${preco}&descricao=${descricao}&quantidade=${quantidade}&id_produto=${id_produto}&mode=update`;
    }
    
    if(form.salva_produto.value == "create"){
        data = `acao=salva_produto&nome=${nome}&preco=${preco}&descricao=${descricao}&quantidade=${quantidade}&mode=create`
    }
    

    httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
				var response = httpRequest.responseText
                mostraMsgCadastro(response);
                form.reset();
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/produto.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(data);
}

function mostraMsgCadastro(msg){

    msg= msg.split(".");
    var msgCadastro = msg[1];
    var alert = document.getElementById("alert-cadastro");
    
    alert.innerHTML = msgCadastro;
    
    if (msg[0] == "bad"){
        alert.classList.remove("alert-success");
        alert.classList.add("alert-danger");
    }

    if(msg[0] == "info"){
        alert.classList.remove("alert-success");
        alert.classList.add("alert-info");
    }

    alert.classList.remove("d-none")

}

function produtoPorId(idProduto){

    httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
				var response = JSON.parse(httpRequest.responseText)
                preencheForm(response);
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/produto.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(`acao=produto_por_id&id_produto=${idProduto}`);
}

function preencheForm(objeto){
    var inputNome = document.getElementById("nome");
    var inputPreco = document.getElementById("preco")
    var inputDescricao = document.getElementById("descricao")
    var inputQuantidade = document.getElementById("quantidade")
    inputNome.value = objeto.nome;
    inputPreco.value = objeto.preco;
    inputDescricao.value = objeto.descricao;
    inputQuantidade.value = objeto.quantidade;
    var btnSubmit = document.getElementById("btn-submit");
    btnSubmit.setAttribute("value", "update");
}

function deletaProduto(idProduto){
    var autrizacao = confirm("Você tem certeza que deseja excluir o cadastro deste produto?");
    if(autrizacao){
        httpRequest.onreadystatechange = function(){
            if (httpRequest.readyState == 4) {
                if (httpRequest.status === 200) {
                    var response = httpRequest.responseText
                    mostraMsgCadastro(response)
                    listaProdutos()
                } else {
                    alert('Houve um problema com esta requisição, contate o Administrador.');
                }
            }
        }
    
        httpRequest.open('POST', `../Controllers/produto.php`, true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send(`acao=deleta_produto&id_produto=${idProduto}`);
    }
}