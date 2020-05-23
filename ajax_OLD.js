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
     var ende   = document.getElementById("txtende").value;
     var regiao = document.getElementById("txtregiao").value;
     var bairro = document.getElementById("txtbairro").value;
     var prestador = document.getElementById("txtprestador").value;
     var cep    = document.getElementById("txtcep").value;
     var result = document.getElementById("Resultado");
     var xmlreq = CriaRequest();
     
     // Exibi a imagem de progresso
     //result.innerHTML = '<img src="Progresso1.gif"/>';
     
     // Iniciar uma requisição
     xmlreq.open("GET", "ListaEleitor.php?txtnome="+nome+"&txtende="+ende+"&txtregiao="+regiao+"&txtbairro="+bairro+"&txtprestador="+prestador+"&txtcep="+cep, true);
     
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