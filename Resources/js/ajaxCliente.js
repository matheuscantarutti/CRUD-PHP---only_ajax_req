
var httpRequest;

if (window.XMLHttpRequest) { 
    httpRequest = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
}



function listaClientes(){
	httpRequest.onreadystatechange = function(){
		if (httpRequest.readyState == 4) {
			if (httpRequest.status === 200) {
                
				var response = JSON.parse(httpRequest.responseText);
				preencheTabelaClientes(response);
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/cliente.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send('acao=lista_clientes');
}

function preencheTabelaClientes(lista_objetos){
    
    var bodyTabela = document.getElementById("body-tabela-cliente");

    while(bodyTabela.firstChild){
        bodyTabela.removeChild(bodyTabela.firstChild);
    }

    if (lista_objetos.length == 0){
        var linha = document.createElement("tr");
        var dataVazio = document.createElement("td");
        dataVazio.innerHTML = "Nenhum(a) cliente cadastrado(a)"
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
            var dataCpf = document.createElement("td");
            dataCpf.innerHTML = element.cpf
            var dataEmail = document.createElement("td");
            dataEmail.innerHTML = element.email
            linha.appendChild(dataId);
            linha.appendChild(dataNome);
            linha.appendChild(dataEmail);
            linha.appendChild(dataCpf);
            
            var dataAcoes = colunaAcoes(element.id);
            linha.appendChild(dataAcoes);
    
            bodyTabela.appendChild(linha);
        });
    }

    
}

function colunaAcoes(idCliente){
    var dataAcoes = document.createElement("td");
    var div = document.createElement("div");
    div.classList.add("btn-group")

    var a = document.createElement("a")
    a.innerHTML = "Editar"
    a.classList.add("m-1");
    a.classList.add("btn");
    a.classList.add("btn-sm");
    a.classList.add("btn-primary");
    a.href = `cadastro_cliente.php?id_cliente=${idCliente}`;
    
    var btn = document.createElement("button")
    btn.innerHTML = "Apagar"
    btn.type="button"
    btn.classList.add("m-1");
    btn.classList.add("btn");
    btn.classList.add("btn-sm");
    btn.classList.add("btn-danger");
    btn.addEventListener("click", function() {
        deletaCliente(idCliente);
    });

    div.appendChild(a)
    div.appendChild(btn)
    dataAcoes.appendChild(div);

    return dataAcoes;

}

function salvaCadastro(form){
    var nome = form.nome.value;
    var cpf = form.cpf.value;
    var email = form.email.value;
    var data = "";
    
    if(form.salva_cliente.value == "update"){
        var id_cliente = form.id_cliente.value;
        data = `acao=salva_cliente&nome=${nome}&cpf=${cpf}&email=${email}&id_cliente=${id_cliente}&mode=update`
    }
    
    if(form.salva_cliente.value == "create"){
        data = `acao=salva_cliente&nome=${nome}&cpf=${cpf}&email=${email}&mode=create`
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

    httpRequest.open('POST', `../Controllers/cliente.php`, true);
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

function clientePorId(idCliente){

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

    httpRequest.open('POST', `../Controllers/cliente.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(`acao=cliente_por_id&id_cliente=${idCliente}`);
}

function preencheForm(objeto){
    var inputNome = document.getElementById("nome");
    var inputCpf = document.getElementById("cpf")
    var inputEmail = document.getElementById("email")
    inputNome.value = objeto.nome;
    inputCpf.value = objeto.cpf;
    inputEmail.value = objeto.email;
    var btnSubmit = document.getElementById("btn-submit");
    btnSubmit.setAttribute("value", "update");
}

function deletaCliente(idCliente){
    var autrizacao = confirm("Você tem certeza que deseja excluir o cadastro deste cliente?");
    if(autrizacao){
        httpRequest.onreadystatechange = function(){
            if (httpRequest.readyState == 4) {
                if (httpRequest.status === 200) {
                    var response = httpRequest.responseText
                    
                    mostraMsgCadastro(response)
                    listaClientes()
                } else {
                    alert('Houve um problema com esta requisição, contate o Administrador.');
                }
            }
        }
    
        httpRequest.open('POST', `../Controllers/cliente.php`, true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send(`acao=deleta_cliente&id_cliente=${idCliente}`);
    }
}