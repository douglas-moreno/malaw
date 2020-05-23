<?php
    require('makeSecure.php');
    //include "cabecalho.php";
    if($_SESSION['Admin'] != 1) {
        header('Location:home.php' );
    }
    include "../mysql/mysqli.class.php";
    require_once('formatatudo.class.php');
    $p = new FormataTudo();

    $DB = new mysql();
    $connec = $DB->Connect("mcape067_maladb");
    
    $sqlre = "Select Regiao.Regiao FROM Regiao order by Regiao.Regiao";
    $queryre = $DB->Query($sqlre);
    
    $sqlpresta = "Select * FROM Prestador where Ativo = 1 order by Prestador";
    $querypresta = $DB->Query($sqlpresta);
    
    $sqltipo = "Select Cod_Tipo, Tipo FROM Tipo where Ativo = 1 order by Tipo";
    $querytipo = $DB->Query($sqltipo);
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
        <link rel="stylesheet" href="../foundation-icons/foundation-icons.css">
        <link rel="stylesheet" href="css/multiple-select.css"/>

	<script src="js/vendor/modernizr.js"></script> 
        <script src="ajax.js"></script>
        <script language="javascript" type="text/javascript">
            function mascara(valor){
                var data = valor.value;
                var vnome = valor.name;
                if (data.length == 2){
                    data = data + "/";
                    document.forms.form1[vnome].value = data;
                    return true;
                }
                if (data.length == 5){
                    data = data + "/";
                    document.forms.form1[vnome].value = data;
                    return true;
                }
            }
        </script>
</head> 
<body>
    <?php require_once 'cabeca.php'; ?>
    <div class="row">
        <div class="medium-12 columns">
            <?php require_once 'menu.php'; ?>
        </div>
    </div>
    <form name="form1" target="_blank" method="post" action="imprimir.php">
        <div class="row">
            <div class="medium-12 columns">
                <p align="center">Selecione o(s) item(ns) que deseja Imprimir</p>
            </div>
        </div>
        
        <div class="row">
            <div class="medium-6 columns">
                <div class="panel clearfix">
                    <fieldset><legend>Tipo</legend>
                        <div class="row">
                            <div class="medium-1 column" id="tipoo" style="visibility:hidden">
                                <i class='fi-check' style="color:blue"></i>
                            </div>
                            <div class="medium-2 columns">
                                <label for="eten" class="left inline">Tipo</label>
                            </div>
                            <div class="medium-9 columns">
                                <select id="eten" name="eten" onchange="muda('tipoo','eten')">
                                    <option value="0">Selecione o Tipo</option>
                                    <option value="1">Etiqueta</option>
                                    <option value="2">Envelope</option>
                                    <option value="3">Lista Simples</option>
                                    <option value="4">Lista Detalhada</option>
                                    <option value="5">SMS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div id="cadastroo" class="medium-1 column" style="visibility:hidden"><i class='fi-check' style="color:blue"></i></div>
                            <div class="medium-3 columns">
                                <label><span data-tooltip aria-haspopup="true" class="has-tip" title="Data de Cadastro Inicial e Final">Data Cad.</span></label>
                            </div>
                            <div class="medium-4 columns">
                                <input type="text" id="cadastro1" name="cadastro1" onkeyup="mascara(this)" onchange="muda('cadastroo','cadastro1')" maxlength="10"/>
                            </div>                            
                            <div class="medium-4 columns">
                                <input type="text" id="cadastro2" name="cadastro2" onkeyup="mascara(this)" onchange="muda('cadastroo','cadastro1')" maxlength="10"/>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
            
            <div class="medium-6 columns">                
                <div class="panel clearfix">                    
                    <fieldset><legend>Opção</legend>
                        <div class="row">
                        <div id="check" class="medium-1 column" style="visibility:hidden"><i class='fi-check' style="color:red"></i></div>
                        <div class="medium-3 columns">
                            <label for="mes" class="right inline">Aniversário:</label>
                        </div>
                        <div class="medium-3 columns">                            
                            <?php
                                echo "<select id='dia' name='dia'><option value='0'>Dia</option>";
                                for ($ii=1; $ii<=31; $ii++) {
                                    echo "<option value='$ii'>$ii</option>";
                                }
                                echo "</select>";
                            ?>                                    
                        </div>
                        <div class="medium-5 columns">
                            <select id="mes" name="mes" onchange="muda('check','mes')">
                                <option value="0">Selecione Mês</option>
                                <option value="1">Janeiro</option>
                                <option value="2">Fevereiro</option>
                                <option value="3">Março</option>
                                <option value="4">Abril</option>
                                <option value="5">Maio</option>
                                <option value="6">Junho</option>
                                <option value="7">Julho</option>
                                <option value="8">Agosto</option>
                                <option value="9">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                        </div>
                        <div class="row">
                            <div class="medium-1 columns">
                                &nbsp;
                            </div>
                            <div class="medium-3 columns">
                                <label for="dia2" class="right inline">Até:</label>
                            </div>
                            <div class="medium-3 columns">
                            <?php
                                echo "<select id='dia2' name='dia2'><option value='0'>Dia</option>";
                                for ($ii=1; $ii<=31; $ii++) {
                                    echo "<option value='$ii'>$ii</option>";
                                }
                                echo "</select>";
                            ?>                                    
                            </div>
                            <div class="medium-5 columns">
                                <select id="mes2" name="mes2" onchange="muda('check','mes2')">
                                    <option value="0">Selecione Mês</option>
                                    <option value="1">Janeiro</option>
                                    <option value="2">Fevereiro</option>
                                    <option value="3">Março</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Maio</option>
                                    <option value="6">Junho</option>
                                    <option value="7">Julho</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="medium-6 columns">
                <div class="panel clearfix">
                    <fieldset><legend>Opção</legend>
                        <div id="filho" class="medium-1 column" style="visibility:hidden"><i class='fi-check' style="color:red"></i></div>
                        <div class="medium-1 columns">
                            <label for="filho1" class="left inline">Filho</label>
                        </div>
                        <div class="medium-10 columns">
                            <select id="filho1" name="filho1" onchange="muda('filho','filho1')">
                                <option value="0">Selecione</option>
                                <option value="1">Sou Mae</option>
                                <option value="2">Sou Pai</option>
                            </select>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="medium-6 columns">
                <div class="panel clearfix">
                    <fieldset><legend>Ordenar por</legend>
                        <div id="ordem1" class="medium-3 columns">
                            <label for="ordem1" class="right inline">Ordem</label>
                        </div>
                        <div class="medium-9 columns">
                            <input type="radio" name="ord" value="1" id='end' checked><label for="end">Endereço, Num</label>
                            <input type="radio" name="ord" value="2" id='nom'><label for="nom">Nome</label>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        
        <div class="panel">
            <div class="row">
                <div class="medium-6 columns">                
                    <label>Prestador
                        <select id="prestador" name="prestador" onchange="pegaValorp()" multiple="multiple">
                            <!-- <option value="0">Prestador</option> -->
                            <?php
                                while ($linha1 = $DB->FetchArray($querypresta)) {
                                    echo "<option value='".$linha1['Codigo_Prestador']."'>".$linha1['Prestador']."</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <input type="hidden" id="prestadors" name="prestadors" />
                </div>
                <div class="medium-6 columns">
                    <label> Tipo
                        <select id="tipo" name="tipo" onchange="pegaValort()" multiple="multiple">
                            <?php
                                while ($linha2 = $DB->FetchArray($querytipo)) {
                                    echo "<option value='" .$linha2['Cod_Tipo'] . "'>" . $linha2['Tipo'] . "</option>" ;
                                }
                            ?>
                        </select>
                    </label>
                    <input type="hidden" id="tipos" name="tipos" />
                </div>
            </div>
        </div>
        
        <div class="panel secondary">
            <div class="row">
                <div class="medium-2 columns">
                    <label>CEP
                        <input type="text" name="cep" id="cep" onblur="peganumero()" placeholder="CEP">
                    </label>
                </div>
                <div class="medium-2 columns">
                    <label>Num
                        <div id="numeros" name="numeros"></div>
                        <input type="hidden" id="numeross" name="numeross" />
                    </label>
                </div>
                <div class="medium-2 columns">
                    <label>Região
                        <select id="regiao" name="regiao">
                            <option value="0">Região</option>
                            <option value="9999">Sem Região</option>
                            <?php 
                                while ($linha = $DB->FetchArray($queryre)) {
                                    echo "<option value='".$linha['Regiao']."'>".$linha['Regiao']."</option>";
                                }
                            ?>
                        </select>
                    </label>
                </div>
                <div class="medium-3 columns">
                    <label>Bairro
                        <input type="text" name="bairro" placeholder="Bairro">
                    </label>
                </div>
                <div class="medium-3 columns">
                    <label>Nome
                        <input type="text" name="nome" placeholder="Eleitor">
                    </label>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="medium-4 columns">
                <input id="btnimprimir" class="button round tiny" type="submit" onClick="mudaAction('imprimir.php','_blank')" value="Imprimir" />
            </div>
            <div class="medium-4 columns">
                <a href="impressao.php" class="button round tiny">Limpar</a>
            </div>
            <div class="medium-4 columns">
                <input id="btnsms" class="button round tiny" type="submit" onClick="mudaAction('smsadmin.php','_self')" value="SMS" />
            </div>
        </div>
    </form>

    <script src="js/vendor/jquery.js"></script>
    <script src="../jquery-ui/jquery-ui.js"></script>
    <script src="../jquery-ui/datepicker-pt-BR.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/multiple-select.js"></script>
    <script>
        $("#prestador").multipleSelect({
            position: 'top',
            placeholder: 'Selecione Prestador(es)'
        });
        $("#tipo").multipleSelect({
            position: 'top',            
            placeholder: 'Selecione Tipo(s)'
        });
    </script>
    <script>
        $(function() {
            $( "#cadastro1" ).datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slide",
                yearRange: "1910:c+1",
            });
            $( "#cadastro2" ).datepicker({
                dateFormat: "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
                showAnim: "slide",
                yearRange: "1910:c+1",
            });
        });            
    </script>
    <script> $(document).foundation(); </script>
</body> 
</html>