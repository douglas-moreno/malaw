<?php
    require('makeSecure.php');
    include "../mysql/mysqli.class.php";
    require_once('formatatudo.class.php');
    $p = new FormataTudo();
    $sqlCliente = "nada";
    $sqlEndereco = "nada";
    $sqlOutras = "nada";
    $sqlServico = "nada";
    $sqlPrestador = "nada";
    $codigo = "";
    $codigos = "";
    $codigoFamilia = 0;

    if (isset($_GET['codcli'])) {
        $codigo = $_GET['codcli'];
        $sqlCliente = "Select * FROM Cliente WHERE Cod_Cliente = $codigo";
        $sqlEndereco = "Select * FROM Endereco WHERE Cod_Cliente = $codigo";
        $sqlOutras = "Select * FROM Outras WHERE Cod_Cliente = $codigo";
        $sqlServico = "Select Servico_Prestado.*, Prestador.Prestador
            FROM Servico_Prestado
            inner join Prestador on Servico_Prestado.Cod_Prestador = 
            Prestador.Codigo_Prestador
            WHERE Cod_Cliente = $codigo";
        $sqlFamilia = "Select Cod_Familia FROM Agregado where Cod_Cliente = $codigo";
        $sqlTel = " Select * FROM Telefone where Cod_Cliente = $codigo";

        $DB = new mysql;
        $connec = $DB->Connect("mcape067_maladb");
        $queryCli = $DB->Query($sqlCliente);
        $queryEnd = $DB->Query($sqlEndereco);
        $queryOutras = $DB->Query($sqlOutras);
        $queryServ = $DB->Query($sqlServico);
        $queryFamilia = $DB->Query($sqlFamilia);
        $queryTel = $DB->Query($sqlTel);

        $linhacli = $DB->FetchArray($queryCli);
        $linhaend = $DB->FetchArray($queryEnd);
        $linhaout = $DB->FetchArray($queryOutras);        
        $familia  = $DB->FetchArray($queryFamilia);
        if ($DB->FetchNum($queryFamilia)>0){
            $conta = 0;
            $codTempFam = $familia["Cod_Familia"];
            $codigoFamilia = $codTempFam;
            $sqlagregados = "Select Cod_Cliente FROM Agregado where Cod_Familia = $codTempFam";
            $queryTempFam = $DB->Query($sqlagregados);
            if ($DB->FetchNum($queryTempFam)>0) {
                while ($linha = $DB->FetchArray($queryTempFam)) {
                    if ($conta == 0) {
                        $codigos = $linha["Cod_Cliente"];
                        $conta = 1;
                    }
                    else {
                        $codigos .= "," . $linha["Cod_Cliente"];
                    }
                }
            }
            //echo $codigos;
        }
    } else {
        header('location: home.php');
    }
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
        <link type="text/css" media="screen" rel="stylesheet" href="../tables/responsive-tables.css" />

        <script type="text/javascript" src="../tables/responsive-tables.js"></script>
        <script src="js/vendor/modernizr.js"></script>
        <style>
            .fi-skull {font-size: 36px}
            .vermelho {color:red;}
        </style>
    </head> 
    <body>
        <?php require_once('cabeca.php'); ?>
        <script type="text/javascript" src="ajax.js"></script>
        <div class="row">
            <div class="medium-12 columns">
                <?php require_once 'menu.php'; ?>        
                <div id="removeModal" class="reveal-modal" data-reveal aria-labelledby="Remover Eleitor" aria-hidden="true" role="dialog">
                    <h1>Confirma Apagar Eleitor ?</h1>
                    <a href="removerEleitor.php?codcli=<?php echo $codigo ?>" data-reveal-id="confirmaModal" data-reveal-ajax="true" class="round button">Confirmar</a>
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                </div>
                <div id="confirmaModal" class="reveal-modal" data-reveal aria-labelledby="Remover Eleitor" aria-hidden="true" role="dialog">
                    <p>Eleitor Removido com Sucesso</p>
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="medium-12 column">
                <form name="formAtualizar" method="post" action="atualizarEleitor.php">
                    <input type="hidden" value="<?php echo $codigo ?>" name="codcli">
                    <div class="panel">
                        <fieldset>
                            <legend>Eleitor <span data-tooltip aria-haspopup="true" class="has-tip" title="Data de Cadastro"> <span class='label tiny round'> <?php echo($p->formatar($linhacli["Data"], "data")) ?> </span></span></legend>
                            <div class="row">
                                <div class="medium-10 columns">
                                    <?php
                                    $mostracli = "<label>Nome
                                                                    <input type='text' name='nome' value='";
                                    $mostracli .= $linhacli["Nome"];
                                    $mostracli .= "'></label>";
                                    echo $mostracli;
                                    ?>		
                                </div>
                                <div class="medium-1 columns">
                                    <?php
                                    $mostracli = "<label>Sexo
									<input type='text' name='sexo' value='";
                                    $mostracli .= $linhacli["Sexo"];
                                    $mostracli .= "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>
                                <div class="medium-1 columns">
                                    <?php
                                    if ($linhacli["Negra"] == 0) {
                                        $mostracli = "<label for='rl' class='right inline'><i class='fi-skull'></i>
                                                                    <input id='rl' type='checkbox' name='negra' onClick=\"return confirm('Confirma alterar o Status?')\"></label> ";
                                    } else {
                                        $mostracli = "<label for='rl' class='right inline'><i class='fi-skull vermelho'></i>
                                                                    <input id='rl' type='checkbox' checked name='negra' onClick=\"return confirm('Confirma alterar o Status?')\"></label>";
                                    }
                                    echo $mostracli;
                                    ?>
                                </div>
                            </div>						
                            <div class="row">
                                <div class="medium-2 column">
                                    <?php
                                    $mostracli = "<label>Aniversário
									<input type='text' name='aniversario' value='";
                                    $mostracli .= $p->formatar($linhacli["Aniversario"], 'data') . "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>
                                <div class="medium-2 column">
                                    <?php
                                    $mostracli = "<label>Título de Eleitor
									<input type='text' name='titulo' value='";
                                    $mostracli .= $linhacli["Titulo"] . "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>
                                <div class="medium-2 column">
                                    <?php
                                    $mostracli = "<label>Zona
									<input type='text' name='zona' value='";
                                    $mostracli .= $linhacli["Zona"] . "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>
                                <div class="medium-2 column">
                                    <?php
                                    $mostracli = "<label>Seção
									<input type='text' name='secao' value='";
                                    $mostracli .= $linhacli["Secao"] . "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>
                                <div class="medium-2 column">
                                    <?php
                                    $mostracli = "<label>Tipo
									<input type='text' name='tipo' value='";
                                    $mostracli .= $linhacli["Tipo"] . "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>
                                <div class="medium-2 column">
                                    <?php
                                    $mostracli = "<label>Filho(a)
									<input type='text' name='filho' value='";
                                    $mostracli .= $linhacli["Filho"] . "'></label>";
                                    echo $mostracli;
                                    ?>
                                </div>							
                            </div>
                            <div class="row">
                                <div class="medium-1 columns">
                                    <?php
                                    $mostraend = "<label>DDD
                                                    <input type='text' name='ddd4' value='";
                                    $mostraend .= $linhaout["ddd4"] . "'></label>";
                                    echo $mostraend;
                                    ?>
                                </div>
                                <div class="medium-2 columns">
                                    <?php
                                    $mostraend = "<label>Celular
								<input type='text' name='celular' value='";
                                    $mostraend .= $p->formatar($linhaout["Celular"], 'celular') . "'></label>";
                                    echo $mostraend;
                                    ?>
                                </div>
                                <div class="medium-9 columns">
                                    <?php
                                    $mostraend = "<label>Observação
								<input type='text' name='obs' value='";
                                    $mostraend .= $linhaout["Obs"] . "'></label>";
                                    echo $mostraend;
                                    ?>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <fieldset>
                        <legend>Endereço</legend>
                        <div class="row">
                            <div class="medium-10 column">
                                <?php
                                $mostraend = "<label>Endereço
									<input type='text' name='endereco' value='";
                                $mostraend .= $linhaend["Endereco"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-2 column">
                                <?php
                                $mostraend = "<label>Numero
											<input type='text' name='numero' value='";
                                $mostraend .= $linhaend["Num"] . "'></label>";
                                echo $mostraend;
                                ?>				
                            </div>
                        </div>
                        <div class="row">
                            <div class="medium-3 columns">
                                <?php
                                $mostraend = "<label>Bairro
									<input type='text' name='bairro' value='";
                                $mostraend .= $linhaend["Bairro"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-3 columns">
                                <?php
                                $mostraend = "<label>Complemento
									<input type='text' name='complemento' value='";
                                $mostraend .= $linhaend["Complemento"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-4 columns">
                                <?php
                                $mostraend = "<label>Cidade
									<input type='text' name='cidade' value='";
                                $mostraend .= $linhaend["Cidade"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-2 columns">
                                <?php
                                $mostraend = "<label>Estado
									<input type='text' name='estado' value='";
                                $mostraend .= $linhaend["Estado"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="medium-3 columns">
                                <?php
                                $mostraend = "<label>Regiao
									<input type='text' name='regiao' value='";
                                $mostraend .= $linhaend["Regiao"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-3 columns">
                                <?php
                                $mostraend = "<label>CEP
									<input type='text' name='cep' value='";
                                $mostraend .= $p->formatar($linhaend["CEP"], 'cep') . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-1 columns">
                                <?php
                                $mostraend = "<label>DDD
									<input type='text' name='ddd' value='";
                                $mostraend .= $linhaend["ddd"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-2 columns">
                                <?php
                                $mostraend = "<label>Telefone
									<input type='text' name='telefone' value='";
                                if (strlen($linhaend["Tel1"]) == 8) {
                                    $mostraend .= $p->formatar($linhaend["Tel1"], 'telefone') . "'></label>";
                                } else {
                                    $mostraend .= $p->formatar($linhaend["Tel1"], 'celular') . "'></label>";
                                }
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-3 columns">
                                <?php
                                $mostraend = "<label>Email
									<input type='text' name='email' value='";
                                $mostraend .= $linhaend["email"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                        </div>
                    </fieldset>
                    <div class="panel">
                        <fieldset>
                            <legend>Serviços</legend>
                            <div class="row">
                                <div class="medium-12 columns">
                                    <?php
                                    $tabela = "
										<table class='responsive'>
										<thead>
											<tr>
												<th>Tipo</th>
												<th>Data</th>
												<th>Descrição</th>
												<th>Prestador</th>
												<th colspan='2'>Ação</th>
											</tr>
										</thead>
										<tbody>";
                                    while ($linha = $DB->FetchArray($queryServ)) {
                                        $tabela .= "<tr><td>" . $linha["Tipo"] . "</td>";
                                        $tabela .= "<td>" . $p->formatar($linha["Data"], 'data') . "</td>";
                                        $tabela .= "<td><textarea cols='70' rows='6' disabled>" . $linha["Descricao"] . "</textarea></td>";
                                        $tabela .= "<td>" . $linha["Prestador"] . "</td>";
                                        $tabela .= "<td><a href='editarservico.php?codcli=" . $codigo . "&codservico=" . $linha["Cod_Servico"] . "'><i class='fi-page-edit'></i></a></td>";
                                        $tabela .= "<td><a href=\"removeservico.php?codcli=" . $codigo . "&codservico=" . $linha["Cod_Servico"] . "\"><i class=\"fi-trash\"></i></a></td></tr>";
                                    }
                                    echo $tabela . "</tbody></table>";
                                    ?>
                                    <?php $chamada = "novoservico2.php?codi=" . $codigo;
                                    ?>

                                    <a href="<?php echo $chamada; ?>" class="round tiny button">Novo Serviço&hellip;</a>


                                    <div id="removeserv" class="reveal-modal" data-reveal aria-labelledby="firstModalTitle" aria-hidden="true" role="dialog"></div>


                                    <div id="addServico" class="reveal-modal" data-reveal aria-labelledby="firstModalTitle" aria-hidden="true" role="dialog">

                                    </div>

                                    <div id="salvaServico" class="reveal-modal" data-reveal>

                                    </div>

                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <fieldset>
                        <legend>Outros</legend>
                        <div class="row">
                            <div class="medium-1 columns">
                                <?php
                                $mostraend = "<label>DDD
                                                    <input type='text' name='ddd2' value='";
                                $mostraend .= $linhaout["ddd2"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-2 columns">
                                <?php
                                $mostraend = "<label>Tel2
								<input type='text' name='tel2' value='";
                                $mostraend .= $p->formatar($linhaout["Tel1"], 'telefone') . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-1 columns">
                                <?php
                                $mostraend = "<label>DDD
                                                    <input type='text' name='ddd3' value='";
                                $mostraend .= $linhaout["ddd3"] . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-2 columns">
                                <?php
                                $mostraend = "<label>Tel3
								<input type='text' name='tel3' value='";
                                $mostraend .= $p->formatar($linhaout["Tel2"], 'telefone') . "'></label>";
                                echo $mostraend;
                                ?>
                            </div>
                            <div class="medium-6 columns">

                            </div>
                        </div>
                    </fieldset>
                    <div class="panel">
                        <fieldset>
                            <legend>
                                Família
                                <?php
                                    if ($codigoFamilia != 0) {
                                        $sqlFam = "Select * FROM Familia where Cod_Familia = $codigoFamilia";
                                        $queryFam = $DB->Query($sqlFam);
                                        $linha = $DB->FetchArray($queryFam);
                                        echo $linha["Nome_Familia"];
                                    }
                                ?>
                            </legend>
                            <div class="row">
                                <div class="medium-12 columns">
                                    <?php
                                        if ($codigoFamilia != 0) {
                                            $sqlagreg = "Select Cliente.Cod_Cliente, Nome, Aniversario, Data, Principal FROM Cliente";
                                            $sqlagreg .= " inner join Agregado on (Cliente.Cod_Cliente = Agregado.Cod_Cliente)";
                                            $sqlagreg .= " where Cliente.Cod_Cliente in ($codigos)";

                                            $queryAgreg = $DB->Query($sqlagreg);

                                            $tabela2 = "<table class='responsive'>
                                                    <thead><tr>
                                                        <th>Detalhe</th>
                                                        <th>Nome</th>
                                                        <th>Aniversário</th>
                                                        <th>Data de Cadastro</th>
                                                        <th>Principal</th>
                                                        </tr>
                                                    </thead><tbody>";
                                            while ($linha = $DB->FetchArray($queryAgreg)) {
                                                $tabela2 .= "<tr><td><a href='detalhe.php?codcli=" . $linha["Cod_Cliente"] . "' class='button tiny round'>Abrir</a></td>";
                                                $tabela2 .= "<td>" . $linha["Nome"] . "</td>";
                                                $tabela2 .= "<td>" . $p->formatar($linha["Aniversario"], 'data') . "</td>";
                                                $tabela2 .= "<td>" . $p->formatar($linha["Data"], 'data') . "</td>";
                                                if ($linha["Principal"] == 1) {
                                                    $tabela2 .= "<td><i class='fi-check'></i></td></tr>";
                                                }
                                                else {
                                                    $tabela2 .= "<td>&nbsp;</td></tr>";
                                                }
                                                //$tabela2 .= "<td><a href='editarservico.php?codcli=" . $codigo . "&codservico=" . $linha["Cod_Servico"] . "'><i class='fi-page-edit'></i></a></td>";
                                                //$tabela2 .= "<td><a href=\"removeservico.php?codcli=" . $codigo . "&codservico=" . $linha["Cod_Servico"] . "\"><i class=\"fi-trash\"></i></a></td></tr>";
                                            }
                                            echo $tabela2 . "</tbody></table>";
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="medium-12 columns">
                                    <?php $chamafamilia = "familia.php?c=$codigo&f=$codigoFamilia" ?>
                                    <a href="<?php echo $chamafamilia; ?>" class="round tiny button">Familia&hellip;</a>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    
                    <fieldset>
                        <legend>Telefones</legend>
                        <?php
                            while ($linhaTel = $DB->FetchArray($queryTel)) {
                                echo ("<div class=\"row\">
                                    <div class=\"medium-6 columns\">"
                                        .$linhaTel["Nome"].
                                    "</div>
                                    <div class=\"medium-1 columns\">"
                                        .$linhaTel["ddd"].
                                    "</div>
                                    <div class=\"medium-5 columns\">"
                                        .$p->formatar($linhaTel["Numero"], 'celular').
                                    "</div>
                                </div>");
                            }
                        ?>
                        <div class="row">
                            <div class="medium-12 columns">
                                <?php $chamatel = "telefone.php?c=$codigo" ?>
                                <a href="<?php echo $chamatel; ?>" class="round tiny button">Telefone&hellip;</a>
                            </div>
                        </div>
                    </fieldset>

                    <div class="row">
                        <div class="medium-12 columns">
                            <input class="button tiny round" type="submit" value="Salvar">
                        </div>
                    </div>
                    <?php
                        $DB->Close();
                    ?>
                </form>
            </div>
        </div>

        <script src="js/vendor/jquery.js"></script> 
        <script src="js/foundation.min.js"></script> 
        <script> $(document).foundation();</script> 
    </body> 
</html>