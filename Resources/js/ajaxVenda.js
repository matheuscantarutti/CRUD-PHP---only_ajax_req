

var httpRequest;

if (window.XMLHttpRequest) { 
    httpRequest = new XMLHttpRequest();
} else if (window.ActiveXObject) { 
    httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
}

function salvaVenda(form){
    var total_preco = form.elements.total_preco;
    var total_qtd = form.elements.total_qtd;
    var id_cliente = form.elements.id_cliente;
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
                console.log(response)
                form.reset();
			} else {
				alert('Houve um problema com esta requisição, contate o Administrador.');
			}
		}
	}

    httpRequest.open('POST', `../Controllers/venda.php`, true);
    httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    httpRequest.send(data);
}

