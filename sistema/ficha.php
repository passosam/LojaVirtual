<script type="text/javascript" src="js/jquery-1.3.2.js"></script> 
<script language="javascript" src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"/></script>
<script type="text/javascript">
    jQuery.noConflict();
(function($) {
$(function() {
$('#CLI_TELEFONE').mask('(99) 9999-9999'); //telefone
$('#CLI_CELULAR').mask('(99) 9999-9999'); //telefone
$('#CLI_DTNASCTO').mask('99/99/9999'); //data
$('#CLI_DTEXPEDICAO').mask('99/99/9999'); //data
$('#MOV_DTENTREGA').mask('99/99/9999'); //data
$('#CLI_CEP').mask('99999-999'); //data


$("#CLI_CNPJCPF").mask("999.999.999-99");//Inicia o campo como CPF
   $("input[name=CLI_TIPOPESSOA]:radio").change(function(){
	 $('#CLI_CNPJCPF').unmask();//Remove a mascara
     if($(this).val()=="F"){//Acaso seja CPF
		$("#CLI_CNPJCPF").mask("999.999.999-99");
	 } else {//Acaso seja Cnpj
		$("#CLI_CNPJCPF").mask("99.999.999/9999-99");
	 }
   })
});
})(jQuery);
</script>

<?php

include ('conexao.php');

$cQry = " SELECT LPAD(p.MOV_CODIGO,6,'0') as MOV_CODIGO, p.*
          FROM movimentacao p ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );

if ( isset( $_GET['do'] ) )
{
    $do = $_GET['do'];
    
    if ( isset( $_GET['id'] ) )
    {
        $id = $_GET['id'];
    }
    else
    {
        $id = "";
    }
}
else
{
    $do = "";
}
	
?>

<div id="page-wrapper">
    <div class="row">
    <div class="col-lg-12">
        <h1>Ficha Atendimento <small>Cadastro/Certid&otilde;es</small></h1>
        
				
<?php

if ( $do == '' )
{
?>  
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-backward"></i> Voltar</a></li>
        <li><a href="index.php?url=ficha&do=new"><i class="fa fa-table"></i> Adicionar</a></li>
    </ol>		
    <div class="col-lg-6">
    <h2>Lista de Fichas Atendimento</h2>
    <div class="table-responsive">

<?php

    if ( $num > 0 )
    {
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Descri&ccedil;&atilde;o <i class="fa fa-sort"></i></th>
                        <th>Banco <i class="fa fa-sort"></i></th>
                        <th>Ag&ecirc;ncia <i class="fa fa-sort"></i></th>                        
                        <th>Conta <i class="fa fa-sort"></i></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';

        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
            echo '<tr>
                        <td>'.$ar['MOV_NUMPEDIDO'].'</td>
                        <td >'.$ar['MOV_DATA'].'</td>
                        <td>'.$ar['MOV_HORA'].'</td>
                        <td>'.$ar['MOV_STATUS'].'</td>
                        <td>'.$ar['MOV_PRAZOENTREGA'].'</td>    
                        <td align=center><a href="index.php?url=ficha&do=edit&id='.$ar['MOV_CODIGO'].'"><img src="image/edit.png" title="Alterar" border=0></a>&nbsp;&nbsp;
                                         <a href="index.php?url=ficha&do=view&id='.$ar['MOV_CODIGO'].'"><img src="image/buscar.png" title="Visualizar" border=0></a>&nbsp;&nbsp;
                                         <a href="index.php?url=ficha&do=del&id='.$ar['MOV_CODIGO'].'"><img src="image/delete.png" title="Excluir" border=0></a></td>
                    </tr>';
        }
        echo '  </tbody>
              </table>';
    }
    else
    {
        echo 'N&atilde;o existem registros cadastrados!';
    }
    ?> 
    </div>
</div>
                
<?php
}
elseif ( $do == "new" || $do == "solicitante" )
{
    if ( $do == "new" )
    {
        //--Retorna o código do pedido
        $cQry = " SELECT MAX(MOV_CODIGO) as CODIGO
                  FROM movimentacao p ";

        $rsc  = mysql_query ( $cQry, $conexao );			
        $ar = mysql_fetch_assoc( $rsc );

        $codpedido = $ar['CODIGO']+1 ;

        $numpedido = str_pad($codpedido, 8, "0", STR_PAD_LEFT); 
        $numpedido = $numpedido.'/'.date(Y);
        $_SESSION['ss_pedido'] = $numpedido;
        $disabled1 = "";
        $cLog1 = "I = Inclusao de ficha atendimento codigo: ".$numpedido;
    }
    $cLog = "I = Inclusao de cliente codigo: ";
        
    
    if ( !empty( $id ) )
    {
         //--Retorna o código do pedido
        $cQry1 = " SELECT p.*, c.*, u.*
                  FROM cliente p
                       inner join cidade c on c.CID_CODIGO = p.CID_CODIGO 
                       inner join uf u on u.UF_CODIGO = c.UF_CODIGO
                  WHERE p.CLI_CODIGO =".$id ;

        $rsc1  = mysql_query ( $cQry1, $conexao );			
        $ar1 = mysql_fetch_assoc( $rsc1 );
                        
    }

    if ( empty( $id ) )
    {
        echo '<form method="post" action="gravarbanco.php?url=ficha&do='.$do.'" id="formcad" name="formcad">';
    }
    else
    {
        echo '<form method="post" action="gravarbanco.php?url=ficha&do='.$do.'&id='.$id.'" id="formcad" name="formcad">';
    }
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados Pessoais do '.( $do == "new"? 'Cliente' : 'Solicitante').'
        </div>';

    echo '<form method="post" action="gravarbanco.php?url=ficha&do='.$do.'" id="formcad" name="formcad">';
   
    
    echo '  <div class="form-group input-group">
                <input type="text" class="form-control" '.$disabled1.' placeholder="Nome do '.( $do == "new"? 'Cliente' : 'Solicitante').'" name="CLI_NOME" id="CLI_NOME" value="'.( !empty($id) ? $ar1['CLI_NOME'] : "").'">
                <input type="hidden" id="CLI_LOG" name="CLI_LOG" value="'.$cLog.'">   
                <input type="hidden" id="USU_CODIGO" name="USU_CODIGO" value="'.$_SESSION['ss_codigo'].'">                    
                <input type="hidden" id="MOV_NUMPEDIDO" name="MOV_NUMPEDIDO" value="'.$_SESSION['ss_pedido'].'"> 
                <input type="hidden" id="MOV_LOG" name="MOV_LOG" value="'.$cLog1.'">     
                <span class="input-group-btn">
                  <button class="btn btn-default" id="cliente" onclick="chamarform(\''.$do.'\');" name="cliente" type="button"><i class="fa fa-search"></i></button>
                </span>    
              </div>';
             
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Endere&ccedil;o</label>
                <input class="form-control" required id="CLI_ENDERECO" '.$disabled1.' placeholder="Rua, Avenida, Estrada" name="CLI_ENDERECO" value="'.( !empty($id) ? $ar1['CLI_ENDERECO'] : "").'">
                <input class="form-control" id="CLI_BAIRRO" '.$disabled1.' placeholder="Bairro" name="CLI_BAIRRO" value="'.( !empty($id) ? $ar1['CLI_BAIRRO'] : "").'">
                <input class="form-control" id="CLI_COMPLEMENTO" '.$disabled1.' placeholder="Complemento e/ou N&uacute;mero" name="CLI_COMPLEMENTO" value="'.( !empty($id) ? $ar1['CLI_COMPLEMENTO'] : "").'">
                <input class="form-control" id="CLI_CEP" '.$disabled1.' placeholder="CEP" name="CLI_CEP" value="'.( !empty($id) ? $ar1['CLI_CEP'] : "").'">    
            </div>';
    
     
    $cQry = " SELECT p.*
              FROM uf p ";

    $rsc  = mysql_query ( $cQry, $conexao );			
        
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">UF</label>
                <select id="CLI_UF" name="CLI_UF" '.$disabled1.' class="form-control1" onchange="setarCampos(this); enviarForm(\'processar.php\', campos, \'divResultado\'); return false;">
                    <option value="">Selecione</option>';
    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['UF_CODIGO'].'" '.( !empty($id) ? ( $ar['UF_CODIGO'] == $ar1['UF_CODIGO'] ? "selected" : "" ) : "").'>'.$ar['UF_SIGLA'].' - '.$ar['UF_NOME'].'</option>';
    }
                
    echo '  </select>
            </div>'; 
    
    echo '  <div id="divResultado" class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Cidade</label>
                <select id="CID_CODIGO" name="CID_CODIGO" '.$disabled1.' class="form-control1">
                    <option value="'.( !empty($id) ?  $ar1['CID_CODIGO'] : "" ).'">'.( !empty($id) ?  $ar1['CID_NOME'] : "Selecione" ).'</option>'; 
    echo '  </select>
            </div>'; 
        
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Filia&ccedil;&atilde;o</label>
                <input class="form-control" required id="CLI_MAE" '.$disabled1.' placeholder="Nome da m&atilde;e" name="CLI_MAE" value="'.( !empty($id) ? $ar1['CLI_MAE'] : "").'">
                <input class="form-control" id="CLI_PAI" '.$disabled1.' placeholder="Nome do pai" name="CLI_PAI" value="'.( !empty($id) ? $ar1['CLI_PAI'] : "").'">
            </div>'; 
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Estado Civil</label>
                <select id="CLI_ESTADOCIVIL" name="CLI_ESTADOCIVIL" '.$disabled1.' class="form-control1" onchange="setarCampos4(this); enviarForm(\'processar4.php\', campos, \'divResultado4\'); return false;">
                    <option value="">Selecione</option>
                    <option value="Solteiro(a)"  '.( !empty($id) ? ( trim($ar1['CLI_ESTADOCIVIL']) == "Solteiro(a)"    ? "selected" : "") : "").'>Solteiro(a)</option>
                    <option value="Casado(a)"    '.( !empty($id) ? ( trim($ar1['CLI_ESTADOCIVIL']) == "Casado(a)"      ? "selected" : "") : "").'>Casado(a)</option>
                    <option value="Divorciado(a)" '.( !empty($id) ? ( trim($ar1['CLI_ESTADOCIVIL']) == "Divorciado(a)" ? "selected" : "") : "").'>Divorciado(a)</option>
                    <option value="Viúvo(a)"     '.( !empty($id) ? ( trim($ar1['CLI_ESTADOCIVIL']) == "Viúvo(a)"       ? "selected" : "") : "").'>Vi&uacute;vo(a)</option>';     
                
    echo '  </select>
            </div>'; 
    
    echo '<div id="divResultado4"></div>';
    
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Profiss&atilde;o</label>
                <input class="form-control" id="CLI_PROFISSAO" '.$disabled1.' placeholder="Profiss&atilde;o do '.( $do == "new"? 'Cliente' : 'Solicitante').'" name="CLI_PROFISSAO"  value="'.( !empty($id) ? $ar1['CLI_PROFISSAO'] : "").'">
            </div>';
    
    echo '<div class="form-group"> 
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo Pessoa</label>
                <label class="radio-inline">
                <input type="radio" name="CLI_TIPOPESSOA" id="CLI_TIPOPESSOA" value="F" '.(( !empty($id) && $ar1['CLI_TIPOPESSOA'] == "F") || ( empty($id)) ? "checked" : "" ).'> F&iacute;sica
                </label>
                <label class="radio-inline">
                <input type="radio" name="CLI_TIPOPESSOA" id="CLI_TIPOPESSOA" value="J" '.(( !empty($id) && $ar1['CLI_TIPOPESSOA'] == "J") ? "checked" : "" ).'> Jur&iacute;dica
                </label>
              </div>';
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">CPF/CNPJ</label>
                <input class="form-control1" id="CLI_CNPJCPF" required '.$disabled1.' placeholder="CPF/CNPJ do  '.( $do == "new"? 'Cliente' : 'Solicitante').'" name="CLI_CNPJCPF" value="'.( !empty($id) ? $ar1['CLI_CNPJCPF'] : "").'">
            </div>'; 
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">RG</label>
                <input class="form-control1" id="CLI_RG" required '.$disabled1.' placeholder="RG do  '.( $do == "new"? 'Cliente' : 'Solicitante').'" name="CLI_RG" value="'.( !empty($id) ? $ar1['CLI_RG'] : "").'">
                <input class="form-control1" id="CLI_EMISSOR" '.$disabled1.' placeholder="Org&atilde;o Emissor do RG" name="CLI_EMISSOR" value="'.( !empty($id) ? $ar1['CLI_EMISSOR'] : "").'"> 
                <input class="form-control1" id="CLI_DTEXPEDICAO" '.$disabled1.' placeholder="Data de Emiss&atilde;o do RG" name="CLI_DTEXPEDICAO" value="'.( !empty($id) ? Stod($ar1['CLI_DTEXPEDICAO']) : "").'">    
            </div>'; 
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Naturalidade</label>
                <input class="form-control1" id="CLI_NATURALIDADE" required '.$disabled1.' placeholder="Naturalidade do  '.( $do == "new"? 'Cliente' : 'Solicitante').'" name="CLI_NATURALIDADE" value="'.( !empty($id) ? $ar1['CLI_NATURALIDADE'] : "").'">
            </div>';
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Nacionalidade</label>
                <input class="form-control1" id="CLI_NATURALIDADE" required '.$disabled1.' placeholder="Nacionalidade do  '.( $do == "new"? 'Cliente' : 'Solicitante').'" name="CLI_NACIONALIDADE" value="'.( !empty($id) ? $ar1['CLI_NACIONALIDADE'] : "").'">
            </div>';
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Fone</label>
                <input class="form-control1" id="CLI_TELEFONE" '.$disabled1.' placeholder="Telefone"  name="CLI_TELEFONE" value="'.( !empty($id) ? $ar1['CLI_TELEFONE'] : "").'">
                <input class="form-control1" id="CLI_CELULAR" '.$disabled1.' placeholder="Celular" name="CLI_CELULAR" value="'.( !empty($id) ? $ar1['CLI_CELULAR'] : "").'">
                <input class="form-control1" id="CLI_RAMAL" '.$disabled1.' placeholder="Ramal" name="CLI_RAMAL" value="'.( !empty($id) ? $ar1['CLI_RAMAL'] : "").'">
            </div>'; 
     
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Nascimento</label>
                <input class="form-control1" id="CLI_DTNASCTO" required '.$disabled1.' placeholder="Data Nascimento" name="CLI_DTNASCTO" value="'.( !empty($id) ? Stod($ar1['CLI_DTNASCTO']) : "").'">
            </div>'; 
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">E-mail</label>
                <input class="form-control" id="CLI_EMAIL" '.$disabled1.' placeholder="E-mail" name="CLI_EMAIL" value="'.( !empty($id) ? $ar1['CLI_EMAIL'] : "").'">
                  </div>';
    if ( $do == "new" )
    {
        echo '<div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Solicitante do Servi&ccedil;o</label>
                <label class="radio-inline">
                <input type="checkbox" name="CLI_SOLICITANTE" id="CLI_SOLICITANTE" value="S" checked> O Mesmo
                </label>
              </div>';
    }
        
    echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Pr&oacute;ximo').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
                </div>';		

}
elseif ( $do == "servico" )
{
    
    echo '<form method="post" action="gravarbanco.php?url=ficha&do='.$do.'" id="formcad" name="formcad">';
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados do Servi&ccedil;o
        </div>';

        
    $cQry = " SELECT p.*
              FROM tiposervico p ";

    $rsc  = mysql_query ( $cQry, $conexao );	
            
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo de Servi&ccedil;o</label>
                <input type="hidden" id="MOV_NUMPEDIDO" name="MOV_NUMPEDIDO" value="'.$_SESSION['ss_pedido'].'">       
                   
                <select id="TIP_CODIGO" name="TIP_CODIGO" '.$disabled1.' class="form-control1" onchange="setarCampos1(this); enviarForm(\'processar1.php\', campos, \'divResultado\'); return false;">
                    <option value="">Selecione</option>';
    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['TIP_CODIGO'].'">'.$ar['TIP_DESCRICAO'].'</option>';
    }
                
    echo '  </select>
            </div>'; 
    
    echo '  <div id="divResultado" class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Servi&ccedil;o</label>
                <select id="SER_CODIGO" name="SER_CODIGO" '.$disabled1.' class="form-control1" onchange="setarCampos2(this); enviarForm(\'processar2.php\', campos, \'divResultado1\'); return false;">
                    <option value="">Selecione</option>'; 
    echo '  </select>
            </div>'; 
        
    echo '  <div id="divResultado1" class="form-group"></div>'; 
    
    echo '<div id="divResultado8"></div>';
    echo '<div id="divResultado9"></div>';
    
    echo '<div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Adicionar outro servi&ccedil;o</label>
                <label class="radio-inline">
                <input type="checkbox" name="MOV_ADICIONAR" id="MOV_ADICIONAR" value="S" checked>
                </label>
              </div>';
        
    echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Pr&oacute;ximo').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
                </div>';		

}
elseif ( $do == "movimentacao" )
{
    $numpedido = $_SESSION['ss_pedido'];
    
    $disabled = "disabled";
    $disabled1 = "";    
    $cLog = "I = Inclusao de titulos codigo: ";
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados da ficha atendimento
        </div>';

    echo '<form method="post" action="gravarbanco.php?url=ficha&do='.$do.'" id="formcad" name="formcad">';
    
    echo '  <div class="form-group">
                <label for="disabledSelect">C&oacute;digo</label>
                <input class="form-control1" type="text" id="MOV_NUMPEDIDO" name="MOV_NUMPEDIDO" '.$disabled.' value="'.$numpedido.'">
                <input type="hidden" id="MOV_NUMPEDIDO" name="MOV_NUMPEDIDO" value="'.$numpedido.'">
                <input type="hidden" id="MOV_LOG" name="MOV_LOG" value="'.$cLog.'">   
                <input type="hidden" id="USU_CODIGO" name="USU_CODIGO" value="'.$_SESSION['ss_codigo'].'">   
            </div>';
    
    echo '  <div id="divResultado1" class="form-group">
            <label for="disabledSelect">Finalidade</label>
            <textarea class="form-control" id="MOV_FINALIDADEDOC" placeholder="Finalidade do Documento" '.$disabled1.' name="MOV_FINALIDADEDOC"></textarea>
        </div>';    
    
    echo '  <div id="divResultado1" class="form-group">
            <label for="disabledSelect">Observa&ccedil;o</label>
            <textarea class="form-control" id="MOV_OBSERVACAO" placeholder="Observa&ccedil;&atilde;o do Servi&ccedil;o" '.$disabled1.' name="MOV_OBSERVACAO"></textarea>
        </div>';  

    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Prazo Entrega</label>
                <select id="MOV_PRAZOENTREGA" name="MOV_PRAZOENTREGA" '.$disabled1.' required class="form-control1">
                    <option value="">Selecione</option>
                    <option value="5">Prazo Local</option>
                    <option value="10">Prazo Estadual</option>
                    <option value="15">Prazo Nacional</option>
                </select>    
                    
            </div>';
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Entrega</label>
                <input class="form-control1" id="MOV_DTENTREGA" required '.$disabled1.' name="MOV_DTENTREGA" value=""> 
            </div>'; 
   
    $cQry = " SELECT p.*
              FROM movimentacao p
              WHERE p.MOV_NUMPEDIDO = '".$numpedido."' ";
    
    $rsc  = mysql_query ( $cQry, $conexao );

    $ar = mysql_fetch_assoc( $rsc );
    
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Valor</label>
                <input class="form-control1" id="MOV_VALOR" '.$disabled.' name="MOV_VALOR" value="'.number_format($ar['MOV_VALOR'], 2, ',', '.').'">
                <input type="hidden" class="form-control1" id="MOV_VALOR" name="MOV_VALOR" value="'.$ar['MOV_VALOR'].'">    
            </div>';       
            
    $cQry = " SELECT p.*
              FROM formapag p ";

    $rsc  = mysql_query ( $cQry, $conexao );			
        
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Forma de Pagamento</label>
                <select id="FOP_CODIGO" name="FOP_CODIGO" '.$disabled1.' required class="form-control1" onchange="setarCampos5(this); enviarForm(\'processar5.php\', campos, \'divResultado5\'); return false;">
                    <option value="">Selecione</option>';
    
    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['FOP_CODIGO'].'">'.$ar['FOP_DESCRICAO'].'</option>';
    }
                
    echo '  </select>
            </div>'; 
    
    echo '<div id="divResultado5"></div>';
    
    $cQry = " SELECT p.*
              FROM condicaopagamento p ";

    $rsc  = mysql_query ( $cQry, $conexao );			
        
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Condi&ccedil;&atilde;o de Pagamento</label>
                <select id="CON_CODIGO" name="CON_CODIGO" '.$disabled1.' required class="form-control1" onchange="setarCampos3(this); enviarForm(\'processar3.php\', campos, \'divResultado7\'); return false;">
                    <option value="">Selecione</option>';
    
    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['CON_CODIGO'].'">'.$ar['CON_DESCRICAO'].'</option>';
    }
    
    echo '  </select>
            </div>'; 
    
    echo '<div id="divResultado7"></div>';
    
    echo '<div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Gerar Recibo</label>
                <label class="radio-inline">
                <input type="checkbox" name="MOV_RECIBO" id="MOV_RECIBO" value="S" checked> 
                </label>
              </div>';
    
    echo '<div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Gerar Procura&ccedil;&atilde;o</label>
                <label class="radio-inline">
                <input type="checkbox" name="MOV_PROCURACAO" id="MOV_PROCURACAO" value="S" checked> 
                </label>
              </div>';
        
    echo '<div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Imprimir Ficha</label>
                <label class="radio-inline">
                <input type="checkbox" name="MOV_IMPRIME" id="MOV_IMPRIME" value="S" checked>
                </label>
              </div>';
        
    echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Pr&oacute;ximo').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
                </div>';		   
}
elseif ( $do == "cliente" || $do == "cliente1" )
{
    echo '<ol class="breadcrumb">
            <li><a href="index.php?url=ficha&do='.( $do == "cliente" ? "new" : "solicitante" ).'"><i class="fa fa-backward"></i> Voltar</a></li>
          </ol>';
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Selecione o '.( $do == "cliente"? 'Cliente' : 'Solicitante').'
        </div>';
    
    $cQry = " SELECT LPAD(p.CLI_CODIGO,6,'0') as CODIGO, p.*
              FROM cliente p ";

    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
    
    if ( $num > 0 )
    {
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th></th>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Cliente <i class="fa fa-sort"></i></th>
                        <th>CNPJ <i class="fa fa-sort"></i></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';

        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
            echo '<tr>
                        <td><input type=radio name=codigocli onclick="voltaform(\''.$do.'\', \''.$ar['CLI_CODIGO'].'\')" id=codigocli value='.$ar['CLI_CODIGO'].'></td>
                        <td>'.$ar['CODIGO'].'</td>
                        <td>'.$ar['CLI_NOME'].'</td>  
                        <td>'.$ar['CLI_CNPJCPF'].'</td>    
                  </tr>';
        }
        echo '  </tbody>
              </table>';
    }
  
}
function Stod( $cData ) { 
    $cRet = substr( $cData, 8, 10 )."/".substr( $cData, 5, 2 )."/".substr( $cData, 0, 4 ); 
    return $cRet;
}
?>
<script>
//Cria a função com os campos para envio via parâmetro
function setarCampos() {
    campos = "uf="+encodeURI(document.getElementById('CLI_UF').value);
}
function setarCampos1() {
    campos = "servico="+encodeURI(document.getElementById('TIP_CODIGO').value);
}
function setarCampos2() {
    campos = "dados="+encodeURI(document.getElementById('SER_CODIGO').value);
}
function setarCampos3() {
    campos = "dados="+encodeURI(document.getElementById('CON_CODIGO').value);
}
function setarCampos4() {
    campos = "dados="+encodeURI(document.getElementById('CLI_ESTADOCIVIL').value);
}
function setarCampos5() {
    campos = "dados="+encodeURI(document.getElementById('FOP_CODIGO').value);
}
function setarCampos6() {
    campos = "dados="+encodeURI(document.getElementById('SEP_TIPO').value)+encodeURI(document.getElementById('SER_CODIGO').value);
}
function setarCampos7() {
    campos = "dados="+encodeURI(document.getElementById('SEP_UF').value)+encodeURI(document.getElementById('SER_CODIGO').value);
}
function chamarform( op ) {
    var tp;
    if ( op == "new" )
    {
        tp = "cliente";
    }
    else 
    {
        tp = "cliente1";
    }
    location.href="index.php?url=ficha&do="+tp;
}
function voltaform( op, id ) {
    var tp;
    if ( op == "cliente" )
    {
        tp = "new";
    }
    else 
    {
        tp = "solicitante";
    }
    location.href="index.php?url=ficha&do="+tp+"&id="+id;
}

</script>
	  </div>
    </div>
</div> 
