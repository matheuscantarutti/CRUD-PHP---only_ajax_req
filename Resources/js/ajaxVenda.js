var httpRequest;

if (window.XMLHttpRequest) { 
    httpRequest = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
}

function salvaVenda(form){
    var total_preco = form.elements.total_preco.value;
    var total_qtd = form.elements.total_qtd.value;
    var id_cliente = form.elements.id_cliente.value;
    var produtos = [];
    var produto;
    
    for (let index = 0; index < form.elements.length; index++) {
        if(form.elements[index].name.indexOf("produto") != -1){
            produto = form.elements[index].value
            produtos[produto] = ""
        }
    }

    produtos.forEach(function(value, key)  {
        var detalhes = [];
        for (let index = 0; index < form.elements.length; index++) {
            if(form.elements[index].name.indexOf(key) != -1){
                var detalhe = form.elements[index].name 
                detalhe = detalhe.split('_');
                detalhes[detalhe[0]] = form.elements[index].value
            }
        }
        produtos[key] = detalhes;
    });

    produtos.forEach(function(value, key){
        var obj = Object.assign({}, value);
        produtos[key] = obj;
    });
    
    var obj = Object.assign({}, produtos);
    produtos = JSON.stringify(obj);

    data = `acao=salva_venda&produtos=${produtos}&id_cliente=${id_cliente}&total_preco=${total_preco}&total_qtd=${total_qtd}`;

    httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
				var response = httpRequest.responseText
                form.reset();
                var divDetalhesVenda = document.getElementById('divDetalhesVenda');
                while(divDetalhesVenda.firstChild){
                    divDetalhesVenda.removeChild(divDetalhesVenda.firstChild);
                }
                var inputQtdVenda = document.getElementsByClassName("inputQtdVenda");
                inputQtdVenda.valus = ""
                mostraMsgCadastro(response)
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/venda.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(data);
}

function listaVendas(){
    data = "acao=lista_vendas";

	httpRequest.onreadystatechange = function(){
        
        if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
                console.log(httpRequest.responseText);
                var response = JSON.parse(httpRequest.responseText);
				preencheTabelaVendas(response)
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/venda.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(data);
}


function preencheTabelaVendas(lista_objetos){
    
    var bodyTabela = document.getElementById("body-tabela-venda");

    while(bodyTabela.firstChild){
        bodyTabela.removeChild(bodyTabela.firstChild);
    }

    if (lista_objetos.length == 0){
        var linha = document.createElement("tr");
        var dataVazio = document.createElement("td");
        dataVazio.innerHTML = "Nenhum(a) venda cadastrado(a)"
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
            dataPreco.innerHTML = parseFloat(element.preco).toFixed(2)
            var dataDescricao = document.createElement("td");
            dataDescricao.innerHTML = element.data_venda
            var dataQuantidade = document.createElement("td");
            dataQuantidade.innerHTML = element.quantidade
            linha.appendChild(dataId);
            linha.appendChild(dataNome);
            linha.appendChild(dataPreco);
            linha.appendChild(dataQuantidade);
            linha.appendChild(dataDescricao);
    
            bodyTabela.appendChild(linha);
        });
    }
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

