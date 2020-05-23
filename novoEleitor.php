<?php
    require('makeSecure.php');
    //include "cabecalho.php";
    include "../mysql/mysqli.class.php";
    require_once('formatatudo.class.php');
    $p = new FormataTudo;
    $sqlCliente = "nada";
    $sqlEndereco = "nada";
    $sqlOutras = "nada";
    $sqlServico = "nada";
    $sqlPrestador = "nada";
    $codigo = "";
    
    $sqlregiao = "Select * FROM Regiao";    
    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    $queryregiao = $DB->Query($sqlregiao);
?>

<!DOCTYPE html> 
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]--> 
<html class="no-js" lang="en" > 
<head> 
	<meta charset="utf-8"> 
	<!-- If you delete this meta tag World War Z will become a reality --> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>Web Mala</title> 
	<!-- If you are using the CSS version, only link these 2 files, you may add app.css to use for your overrides if you like --> 
	<link rel="stylesheet" href="css/normalize.css"> 
	<link rel="stylesheet" href="css/foundation.css"> 

	<script src="js/vendor/modernizr.js"></script> 
        <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->
        <script language="javascript" type="text/javascript">
            function mascara(valor){
                var data = valor.value;
                if (data.length == 2){
                    data = data + "/";
                    document.form1.aniversario.value = data;
                    return true;
                }
                if (data.length == 5){
                    data = data + "/";
                    document.form1.aniversario.value = data;
                    return true;
                }
            }
        </script>
        
</head> 
<body> 
    <?php require_once 'cabeca.php'; ?>
    <?php require_once 'menu.php'; ?>
    <form name="form1" method="POST" action="salvarEleitor.php" data-abide>
        <div class="panel callout radius">
            <fieldset>
                <legend>Novo Eleitor</legend>
                <div class="row">
                    <div class="medium-11 columns">			
                        <label>Eleitor
                            <input type="text" name="nome" required pattern="[a-zA-Z]+" autofocus />
                        </label>
                        <small class="error">Campo Obrigatorio - Somente Letras</small>
                    </div>
                    <div class="medium-1 columns">
                        <label>Sexo
                            <select name="sexo" required>
                                <option value="">Selecione</option>
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </label>
                        <small class="error">Selecione o Sexo</small>
                    </div>
                </div>		
                <div class="row">
                    <div class="medium-2 columns">
                        <label>Aniversário
                            <!-- <input type="text" name="aniversario" id="aniversario"/> -->
                            <input type="text" required id="aniversario" name="aniversario" onkeyup="mascara(this)" maxlength="10"/> 
                        </label>
                        <small class="error">Selecione a Data</small>
                    </div>
                    <div class="medium-2 columns">
                        <label>Título de Eleitor
                            <input type="text" name="titulo">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Zona
                            <input type="text" name="zona">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Seção
                            <input type="text" name="secao">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Possui Filho
                            <select name="filho" required>
                                <option value="">Escolha uma opção</option>
                                <option value="Sim">Sim</option>
                                <option value="Nao">Nao</option>
                            </select>
                        </label>
                        <small class="error">Selecione uma opção</small>
                    </div>
                    <div class="medium-2 columns">
                        <label>Tipo
                            <input type="text" name="tipo">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-1 columns">
                        <label>DDD
                            <input name="ddd4" type="text" value="11">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Celular
                            <input name="celular" type="text">
                        </label>
                    </div>
                    <div class="medium-9 columns">
                        <label>Observação
                            <input name="obs" type="text">
                        </label>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="panel">
            <fieldset>		
                <legend>Endereço</legend>
                <div class="row">
                    <div class="medium-10 columns">
                        <label>Endereço
                            <input type="text" id="endereco" name="endereco" required>
                            <small class="error">Campo Obrigatório</small>
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Numero
                            <input type="text" id="numero" name="numero" required>
                            <small class="error">Campo Obrigatório</small>
                        </label>	
                    </div>
                </div>
                <div class="row">
                    <div class="medium-3 columns">
                        <label>Bairro
                            <input id="bairro" name="bairro" type="text">
                        </label>
                    </div>
                    <div class="medium-3 columns">
                        <label>Complemento
                            <input name="complemento" type="text">
                        </label>
                    </div>
                    <div class="medium-3 columns">
                        <label>Cidade
                            <input id="cidade" name="cidade" type="text">
                        </label>
                    </div>
                    <div class="medium-3 columns">
                        <label>Estado
                            <input id="estado" name="estado" type="text">
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="medium-3 columns">
                        <label>Região
                            <select name="regiao" id="regiao" required>
                                <option value="">Selecione Região</option>
                                <?php
                                while ($linha = $DB->FetchArray($queryregiao)) {
                                    echo "<option value='" . $linha["Regiao"] . "'>" . $linha["Regiao"] . "</option>";
                                }
                                $DB->Close();
                                ?>
                            </select>
                        </label>
                        <small class="error">Campo Obrigatório</small>
                    </div>
                    <div class="medium-3 columns">
                        <span class='round label'>CEP
                            <input id="cep" name="cep" type="text" value="0" required>
                        </span>
                        <small class="error">Campo Obrigatório</small>
                    </div>
                    <div class="medium-1 columns">
                        <label>DDD
                            <input name="ddd" type="text" value="11">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Telefone
                            <input name="telefone" type="text">
                        </label>
                    </div>
                    <div class="medium-3 columns">
                        <label>Email
                            <input name="email" type="text">
                        </label>
                    </div>
                </div>
            </fieldset>	
        </div>
        <div class="panel callout radius">	
            <fieldset>
                <legend>Serviços</legend>
                <table role='grid'>
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Prestador</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </fieldset>	
        </div>
        <div class="panel">
            <fieldset>
                <legend>Outros</legend>	
                <div class="row">
                    <div class="medium-2 columns">
                        <label>DDD
                            <input name="ddd2" type="text">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Telefone 2
                            <input name="tel2" type="text">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>DDD
                            <input name="ddd3" type="text">
                        </label>
                    </div>
                    <div class="medium-2 columns">
                        <label>Telefone 3
                            <input name="tel3" type="text">
                        </label>
                    </div>
                    <div class="medium-4 columns">

                    </div>
                </div>
            </fieldset>
        </div>
        <div class="panel">
            <fieldset>
                <legend>Familia</legend>
                <div class="row">
                    <div class="medium-12 columns">
                        
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="row">
            <div class="medium-12 columns">
                <input class="button round tiny" type="Submit" value="Salvar">
            </div>
        </div>
    </form>


	<script src="js/vendor/jquery.js"></script>
	<script src="../jquery-ui/jquery-ui.js"></script> 
        <script src="../jquery-ui/datepicker-pt-BR.js"></script> 
        
        <script type='text/javascript' src='cep.js'></script> 
        <script>
            $(function() {
                $( "#aniversario" ).datepicker({
                    dateFormat: "dd/mm/yy",
                    changeMonth: true,
                    changeYear: true,
                    showAnim: "slide",
                    yearRange: "1910:c+1",
                });
            });            
        </script>
	<script src="js/foundation.min.js"></script>
	<script> $(document).foundation(); </script> 
</body> 
</html>