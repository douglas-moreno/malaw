/**
  * Função para criar um objeto XMLHTTPRequest
  */
 function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
         
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
         
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
     
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
 
 /**
  * Função para enviar os dados
  */
 function getDados() {
     
     // Declaração de Variáveis
     var nome   = document.getElementById("txtnome").value;
     var pagi   = document.getElementById("txtpagina").value;
     var fam    = document.getElementById("f").value;
     var ende   = document.getElementById("txtende").value;
     var regiao = document.getElementById("txtregiao").value;
     var bairro = document.getElementById("txtbairro").value;
     var prestador = document.getElementById("txtprestador").value;
     var cep    = document.getElementById("txtcep").value;
     var result = document.getElementById("Resultado");
     var xmlreq = CriaRequest();
     
     // Exibi a imagem de progresso
     result.innerHTML = '<img src="img/ampulheta.png" alt="ampulheta" height="42" width="42" />';
     
     // Iniciar uma requisição
     xmlreq.open("GET", "ListaEleitor.php?txtnome="+nome+"&txtpag="+pagi+"&txtende="+ende+"&txtregiao="+regiao+"&txtbairro="+bairro+"&txtprestador="+prestador+"&txtcep="+cep+"&f="+fam, true);
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }

 function addServForm() {
     
     // Declaração de Variáveis
     var nome   = document.getElementById("codcli").value;
     var result = document.getElementById("Resultado");
     var xmlreq = CriaRequest();
     
     result.innerHTML = '<img src="img/ampulheta.png" alt="ampulheta" height="42" width="42" />';
     
     // Iniciar uma requisição
     xmlreq.open("GET", "novoservico.php?txtnome=" + nome, true);
     //xmlreq.open("GET", "novoservico.php", true);
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }

 function addServico() {
     
     // Declaração de Variáveis     
     var codigo1   = document.getElementById("codic").value;
     var tipo      = document.getElementById("ntipo").value;
     var descricao = document.getElementById("ndesc").value;
     var prestador = document.getElementById("nprestador").value;
     var result    = document.getElementById("Resultado");
     var xmlreq    = CriaRequest();
     
     result.innerHTML = '<img src="img/ampulheta.png" alt="ampulheta" height="42" width="42" />';
     
     // Iniciar uma requisição
     xmlreq.open("GET", "addnovoservico.php?txtnome=" + codigo1, true);
     //xmlreq.open("GET", "novoservico.php", true);
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }
 
 function getTela(valor) {
     
     // Declaração de Variáveis          
     var result    = document.getElementById("Resultado");
     var xmlreq    = CriaRequest();
     
     result.innerHTML = '<img src="img/ampulheta.png" alt="ampulheta" height="42" width="42" />';
     
     if (valor == 1) {
         xmlreq.open("GET", "getUsuario.php", true);
     }
     else if (valor == 2) {
         xmlreq.open("GET", "getTipo.php", true);
     }
     else {
         xmlreq.open("GET", "getRegiao.php", true);
     }     
     
     // Iniciar uma requisição
     //xmlreq.open("GET", "addnovoservico.php?txtnome=" + codigo1, true);
     //xmlreq.open("GET", "novoservico.php", true);
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }
 
 function muda(opcao, elemento) {
    var valor = document.getElementById(elemento).value;
    if (valor != 0){
        document.getElementById(opcao).style.visibility="visible";
    }
    else {                    
        document.getElementById(opcao).style.visibility="hidden";
    }
    if (valor == 5){
        document.getElementById("btnimprimir").style.visibility="hidden";
        document.getElementById("btnsms").style.visibility="visible";
    }
    else {
        document.getElementById("btnimprimir").style.visibility="visible";
        document.getElementById("btnsms").style.visibility="hidden";
    }
}

function pegaValorp() {
    document.getElementById("prestadors").value = $("#prestador").multipleSelect("getSelects");
}

function pegaValort() {
    document.getElementById("tipos").value = $("#tipo").multipleSelect("getSelects");
}

function pegaValorn() {
    document.getElementById("numeross").value = $("#nume").multipleSelect("getSelects");
}

function mudaAction(pagina, onde){
    document.forms[0].action=pagina;
    document.forms[0].target=onde;
    document.forms[0].submit();
}

function peganumero(){
    var txtcep    = document.getElementById("cep").value;
    var result = document.getElementById("numeros");
    var xmlreq = CriaRequest();

    // Exibi a imagem de progresso
    result.innerHTML = '<img src="img/ampulheta.png" alt="ampulheta" height="32" width="32" />';

    // Iniciar uma requisição
    xmlreq.open("GET", "numerocep.php?txtcep="+txtcep, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
     xmlreq.send(null);
}

function numerocep(){
    $("#nume").multipleSelect({
        position: 'top',
        placeholder: 'Numero(s)'
    });
}