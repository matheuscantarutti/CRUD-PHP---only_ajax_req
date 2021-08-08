
var httpRequest;

if (window.XMLHttpRequest) { 
    httpRequest = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
}



function listaProdutos(){
	httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
                
				var response = JSON.parse(httpRequest.responseText);
				preencheTabelaProdutos(response);
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/produto.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('acao=lista_produtos');
}

function preencheTabelaProdutos(lista_objetos){
    
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
            
            var dataAcoes = colunaAcoes(element.id);
            linha.appendChild(dataAcoes);
    
            bodyTabela.appendChild(linha);
        });
    }

    
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