
<script type="text/javascript" src="js/jquery-1.3.2.js"></script> 
<script language="javascript" src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"/></script>
<script type="text/javascript" src="js/jquery.maskMoney.js"></script>
<script type="text/javascript">
<script type="text/javascript">
    jQuery.noConflict();
(function($) {
$('#ORS_DTINICIO').mask('99/99/9999'); //data
$('#ORS_HORAINICIO').mask('99:99'); //data
$('#COM_HRINICIO').mask('99:99'); //data
$('#COM_HRFIM').mask('99:99'); //data
$("#DEP_VALOR").maskMoney();

});
})(jQuery);


</script>
<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<script>
	$(document).ready(function(){

		$("a").click(function(event){
			var link = $(this);			

			if(link.attr("id").match("esconder"))
				$("#MeuDiv").hide("slow");
			else
				$("#MeuDiv").show("slow");

			event.preventDefault();
		});
	})
</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script>
function buscar_cidades(){
  var estado = $('#CLIENTE').val();
  if(estado){
	var url = 'ajax_buscar_cidades.php?CLIENTE='+estado;
	$.get(url, function(dataReturn) {
	  $('#load_cidades').html(dataReturn);
	});
  }
}
</script>

<script type="text/javascript" src="prototype.js"></script>
<script language="javascript">
function CarregaCidades(codEstado)
{
	if(codEstado){
		var myAjax = new Ajax.Updater('cidadeAjax','carrega_cidades.php?cliente='+codEstado,
		{
			method : 'get',
		}) ;
	}
	
}
</script>



<?php

include ('conexao.php');

$cQry = " SELECT LPAD(p.ORS_CODIGO,6,'0') as ORS_CODIGO, p.*
          FROM apl_ordemservico p ";

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
        <h1>Ordem de Servi&ccedil;o <small>       
				
<?php
	echo ''.($do == 'acomp' ? 'Acompanhar': ($do == 'alt' ? 'Altera&ccedil;&atilde;o' :( $do == 'fec'? 'Fechar' : 
	        ($do == 'rel' ? 'Relat&oacute;rio' : ( $do == 'grafico' ? 'Gr&aacute;fico' : 'Abertura'))))).'</small></h1>';

if ( $do == 'acomp' )
{
?>  
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-backward"></i> Voltar</a></li>
    </ol>
		
<?php
	if (isset($_POST['CONSULTA']))	
	{
		$consulta = $_POST['CONSULTA'];
	}
	else
	{
		$consulta = "";
	}
    
	if (isset($_POST['CLIENTE']))	
	{
		$clientec = $_POST['CLIENTE'];
	}
	else
	{
		$clientec = "";
	}
	
	if (isset($_POST['EQP']))	
	{
		$eqpc = $_POST['EQP'];
	}
	else
	{
		$eqpc = "";
	}
	$cQry = " SELECT os.*,c.CLI_NOME, s.TPS_CODIGOTIPOSER, s.TPS_DESCRICAO, 
	                 e.EQP_NOME, e.EQP_MODELO, u.USU_NOME
              FROM apl_ordemservico os
					INNER JOIN apl_cliente c
					ON os.cli_codigo = c.cli_codigo 
					INNER JOIN apl_tpservico s
					ON os.TPS_CODIGO = s.TPS_CODIGO	
					INNER JOIN apl_equipamento e
					ON os.EQP_CODIGO = e.EQP_CODIGO	
					INNER JOIN apl_usuario u
					ON os.USU_CODIGO = u.USU_CODIGO ";
	if (!empty($consulta))
	{	
		$cQry .= "WHERE os.ORS_STATUS = '".$consulta."' ";	
	}	
	else
	{
		$cQry .= "WHERE os.ORS_STATUS <> 'F' ";	
	}

	if (!empty($clientec))
	{
		$cQry .= " AND os.CLI_CODIGO = '".$clientec."' ";	
	}
	
	if (!empty($eqpc))
	{
		$cQry .= " AND os.EQP_CODIGO = '".$eqpc."' ";	
	}
	
	if ($_SESSION['ss_perfil']=='O')
	{
		$cQry .= " AND os.USU_CODIGO = '".$_SESSION['ss_codigo']."' ";	
	}
	
    $cQry .= " ORDER BY os.ORS_NUMERO ASC ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
	
	$cQrycc = " SELECT p.*
			    FROM apl_cliente p  ";

	$rsccc  = mysql_query ( $cQrycc, $conexao );
	
	
	$cQryeq = " SELECT e.*
			    FROM apl_equipamento e  ";

	$rsceq  = mysql_query ( $cQryeq, $conexao );

/*

			<tr><td width="32%"><b>Data Abertura:</b></td>
				<td><input class="btn btn-default1" id="DTINI" name="DTINI" value=""> a   <input class="btn btn-default1" id="DTFIM" name="DTFIM" value=""></td></tr>
			
			<tr><td width="32%"><b>Data Fechamento:</b></td>
				<td><input class="btn btn-default1" id="DTFECI" name="DTFECI" value=""> a   <input class="btn btn-default1" id="DTFECF" name="DTFECF" value=""></td></tr>
			
*/
    echo '<form method="post" action="index.php?url=os&do=acomp" id="formcad" name="formcad">';
	echo '<table style="border: 1px solid #ccc" align=center width=40%><tr><td colspan=2 align=center><b>Filtros</b></td></tr>
					<tr><td colspan=2 align=center><a id="exibir"><b>Exibir </b></a><b><a id="esconder">Ocultar</a></b>
	</td></tr></table>';
	echo ' <div id="MeuDiv"><table align=center style="border: 1px solid #ccc" width=40% CELLSPACING=2 CELLPADDING=4>
			
			
			
			<tr><td width="32%"><b>Cliente:</b></td>	
			    <td><select id="CLIENTE" name="CLIENTE" onchange="buscar_cidades()" class="form-control7">
					<option value="">Selecione o cliente</option>';
	
			while ( $arcc = mysql_fetch_assoc( $rsccc ) )
			{
				echo '<option value="'.$arcc['CLI_CODIGO'].'">'.$arcc['CLI_NOME'].'</option>';
			}
	
			echo '</select></td></tr>
	
			<tr><td width="32%"><b>Equipamento:</b></td>	
							<td><div id="load_cidades"><select id="EQP" name="EQP" class="form-control7">
								<option value="">Selecione o equipamento</option>';
								
				
			echo '</select></div></td></tr>	
			
			
			<tr><td width="32%"><b>Status do Chamado:</b></td>	
			    <td><select id="CONSULTA" name="CONSULTA" class="form-control6">
					<option value="" '.( empty($consulta) ? "SELECTED" : "").'>Aberto</option>
					<option value="F" '.( $consulta == "F" ? "SELECTED" : "").'>Fechado</option>
					</select>
				<button type="submit" class="btn btn-default">>></button></div><br><br></td></tr>';
			
			
	
	echo '</table></div>';
    
    if ( $num > 0 )
    {
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
						<th></th>
                        <th>Chamado <i class="fa fa-sort"></i></th>
                        <th>Cliente <i class="fa fa-sort"></i></th>						
                        <th>Equipamento <i class="fa fa-sort"></i></th> 
                        <th>Servi&ccedil;o <i class="fa fa-sort"></i></th>                        
                        <th>Operador <i class="fa fa-sort"></i></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';

        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
            echo '<tr>
						<td><input type="checkbox" name="op" id="op" value="'.$ar['ORS_CODIGO'].'"> </td>
                        <td>'.$ar['ORS_NUMERO'].'</td>
                        <td>'.$ar['CLI_NOME'].'</td>
                        <td>'.$ar['EQP_NOME'].'/'.$ar['EQP_MODELO'].'</td>
                        <td>'.$ar['TPS_CODIGOTIPOSER'].'/'.$ar['TPS_DESCRICAO'].'</td>
                        <td>'.$ar['USU_NOME'].'</td>    
                  </tr>';
				  
			$cQry1 = "SELECT COM_DATA, COM_HRINI, COM_HRFIM, COM_DESCRICAO, 
			                 COM_TIPO, COM_KM, COM_TPHORA
					  FROM apl_complemento com	
					  WHERE com.ORS_CODIGO = '".$ar['ORS_CODIGO']."' ";
    
			$rsc1 = mysql_query( $cQry1, $conexao );	 

			$num1 = mysql_num_rows( $rsc1 );	
			
			$i = 0;
			
			if ( $num1 > 0 )
			{
				while ( $ar1 = mysql_fetch_assoc( $rsc1 ) )
				{
					echo '<tr>';
					
					if ( $i == 0)
					{
						echo '  <td colspan=3 align=center><b>Dias Trabalhados/Horas</b></td>';
					}
					else
					{
						echo '  <td colspan=3 align=center></td>';
					}
					echo '	<td>'.Stod($ar1['COM_DATA']).'</td>
							<td>'.$ar1['COM_HRINI'].'/'.$ar1['COM_HRFIM'].'</td>
							<td>'.$ar1['COM_DESCRICAO'].'</td>  
						  </tr>';	
					$i++;	  
				}	
			}	
			
			$cQry2 = "SELECT s.*, t.TIP_DESCRICAO 
					  FROM apl_despesas s
                           inner join apl_tipodespesa t on
                            s.TIP_CODIGO = t.TIP_CODIGO 						   
					  WHERE s.ORS_CODIGO = '".$ar['ORS_CODIGO']."' ";
    
			$rsc2 = mysql_query( $cQry2, $conexao );	 

			$num2 = mysql_num_rows( $rsc2 );		

			$i = 0;
			
			if ( $num2 > 0 )
			{
				while ( $ar2 = mysql_fetch_assoc( $rsc2 ) )
				{
					echo '<tr>';
					if ( $i == 0)
					{
						echo ' <td colspan=3 align=center><b>Despesas</b></td>';
					}
					else
					{
						echo ' <td colspan=3 align=center></td>';
					}
					echo '	<td></td>
							<td>'.$ar2['TIP_DESCRICAO'].'</td>
							<td>'.number_format($ar2['DES_VALOR'], 2,",",".").'</td>
						  </tr>';
					$i++;		
				}	
			}
				  
			
			$cQry3 = "SELECT p.*, pec.*
					  FROM apl_ospecas p
                           inner join apl_pecas pec on
                            p.PEC_CODIGO = pec.PEC_CODIGO 						   
					  WHERE p.ORS_CODIGO = '".$ar['ORS_CODIGO']."' ";
    
			$rsc3 = mysql_query( $cQry3, $conexao );	 

			$num3 = mysql_num_rows( $rsc3 );		

			$i = 0;
			
			if ( $num3 > 0 )
			{
				while ( $ar3 = mysql_fetch_assoc( $rsc3 ) )
				{
					echo '<tr>';
					if ( $i == 0)
					{
						echo ' <td colspan=3 align=center><b>Pe&ccedil;as</b></td>';
					}
					else
					{
						echo ' <td colspan=3 align=center></td>';
					}
					echo '	<td></td>
							<td>'.$ar3['PEC_DESCRICAO'].'</td>
							<td>'.$ar3['PEC_CODIGOPEC'].'</td>
						  </tr>';	
					$i++;	  
				}	
			}	  
        }
		if ( $do == 'acomp' )
		{
			echo ' <tr><td colspan=6 align=right>';
			if ($consulta <> 'F')
			{
				echo 							 '<button type="button" onclick="Alt()" class="btn btn-default">Alterar O.S.</button>
										    	 '.($_SESSION['ss_perfil'] == 'A' ? '<button type="button" onclick="Exc()" class="btn btn-default">Excluir O.S.</button>' :'').'
												 <button type="button" onclick="abrir3()" class="btn btn-default">Emiss&atilde;o de O.S.</button></td></tr>';
			}
			else
			{	
				echo								'<button type="button" onclick="abrir3()" class="btn btn-default">Emiss&atilde;o de O.S.</button></td></tr>';
			}	
		}
		echo '</tbody>
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
elseif ( $do == "new" || $do == "solicitante" || $do == "alt" )
{
    if ( $do == "new" )
    {
		echo '<ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-backward"></i> Voltar</a></li>
          </ol>';
        //--Retorna o código do pedido
        $cQry = " SELECT MAX(ORS_NUMERO) as CODIGO
                  FROM apl_ordemservico p ";

        $rsc  = mysql_query ( $cQry, $conexao );			
        $ar = mysql_fetch_assoc( $rsc );

        $codpedido = $ar['CODIGO']+1 ;

        $numpedido = str_pad($codpedido, 12, "0", STR_PAD_LEFT); 
        $_SESSION['ss_pedido'] = $numpedido;
        $disabled1 = "";
		$disabled = "disabled";
    }        
    else if ($do == "alt" and empty($id))
	{
		echo '<ol class="breadcrumb">
				<li><a href="index.php?url=os&do=acomp"><i class="fa fa-backward"></i> Voltar</a></li>
			 </ol>';
		  
		$_SESSION['chamado'] = $_GET['id1'];
	}
	
	if ($do == "solicitante")
	{
		$disabled1 = "";
		$disabled = "disabled";
	}
	
	if ( isset($_SESSION['chamado']) ) 
	{
		$op = "";
		
		if (isset($_GET['op']))
		{
			$op = $_GET['op'];
		}
		$disabled1 = "";
		$disabled = "disabled";
		$cQry2 = "SELECT os.*, p.*, e.EQP_NOME, tp.* , usu.*
		         FROM apl_ordemservico os 
                      inner join apl_cliente p on os.CLI_CODIGO = p.CLI_CODIGO
					  inner join apl_equipamento e on e.EQP_CODIGO = os.EQP_CODIGO 
					  inner join apl_tpservico tp on tp.TPS_CODIGO = os.TPS_CODIGO
					  inner join apl_usuario usu on usu.USU_CODIGO = os.USU_CODIGO
 				 WHERE os.ORS_CODIGO = ".$_SESSION['chamado'];
				 
				 
		$rsc2  = mysql_query ( $cQry2, $conexao );			
        $ar2 = mysql_fetch_assoc( $rsc2 );	
		
		$cQry3 = "SELECT comp.*
		         FROM apl_complemento comp
 				 WHERE comp.ORS_CODIGO = ".$_SESSION['chamado'];
				 
		$rsc3  = mysql_query ( $cQry3, $conexao );			
        //$ar3 = mysql_fetch_assoc( $rsc3 );
		$num3 = mysql_num_rows( $rsc3 );	
		
		if (empty( $id ))
		{
			$id = $ar2['CLI_CODIGO'];	
		}		
	}
	
    if ( !empty( $id ))
    {
         //--Retorna o código do pedido
        $cQry1 = " SELECT p.*
                   FROM apl_cliente p
                   WHERE p.CLI_CODIGO =".$id ;

        $rsc1  = mysql_query ( $cQry1, $conexao );			
        $ar1 = mysql_fetch_assoc( $rsc1 );  

    }	

    if ( empty( $id ) )
    {
        echo '<form method="post" action="gravarbanco.php?url=os&do='.$do.'" id="formcad" name="formcad">';
    }
    else if ( $do == "new" || $do == "alt")
    {
        echo '<form method="post" action="gravarbanco.php?url=os&do='.$do.'&id='.$id.'" id="formcad" name="formcad">';
    }
		/*
	echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Abertura de O.S.(Chamado)
        </div>';
	*/
	echo '  <div class="form-group input-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Chamado</label>
                <input type="text" class="form-control4" '.$disabled.'  name="ORS_NUMERO" id="ORS_NUMERO" value="'.($do<>"alt" ? $_SESSION['ss_pedido'] : str_pad($ar2['ORS_NUMERO'], 12, "0", STR_PAD_LEFT)).'">
                <input type="hidden" id="ORS_NUMERO" name="ORS_NUMERO" value="'.($do <> "alt" ? $_SESSION['ss_pedido'] : str_pad($ar2['ORS_NUMERO'], 12, "0", STR_PAD_LEFT)).'"> 
            </div>';	
	
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Abertura</label>
                <input class="form-control3" id="ORS_DTINICIO" required '.$disabled1.' name="ORS_DTINICIO" value="'.($do<>"alt" ? date('d').'/'.date('m').'/'.date('Y') : Stod($ar2['ORS_DTINICIO'])).'"> 
            </div>'; 	
			
	echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Hora Abertura</label>
                <input class="form-control3" id="ORS_HORAINICIO" required '.$disabled1.' name="ORS_HORAINICIO" value="'.($do<>"alt"? date('H').':'.date('i') : $ar2['ORS_HORAINICIO']).'"> 
            </div>'; 		
			  
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados Pessoais do Cliente
        </div>';
    
    echo '  <div class="form-group input-group">
                <input type="text" class="form-control" '.$disabled1.' required placeholder="Nome do Cliente" name="CLI_NOME" id="CLI_NOME" value="'.( !empty($id) ? $ar1['CLI_NOME'] : "").'">
                <input type="hidden" id="CLI_CODIGO" name="CLI_CODIGO" value="'.$id.'"> 
				<span class="input-group-btn">
                  <button class="btn btn-default" id="cliente" onclick="chamarform(\''.$do.'\');" name="cliente" type="button"><i class="fa fa-search"></i></button>
                </span>    
              </div>';
             /*
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Endere&ccedil;o</label>
                <input class="form-control" required id="CLI_ENDERECO" '.$disabled.' placeholder="Rua, Avenida, Estrada" name="CLI_ENDERECO" value="'.( !empty($id) ? $ar1['CLI_ENDERECO'] : "").'">
                <input class="form-control" id="CLI_CIDADE" '.$disabled.' placeholder="Cidade" name="CLI_CIDADE" value="'.( !empty($id) ? $ar1['CLI_CIDADE'] : "").'">
                <input class="form-control" id="CLI_TELEFONE" '.$disabled.' placeholder="Telefone" name="CLI_TELEFONE" value="'.( !empty($id) ? $ar1['CLI_TELEFONE'] : "").'">
                <input class="form-control" id="CLI_UF" '.$disabled.' placeholder="UF" name="CLI_UF" value="'.( !empty($id) ? $ar1['CLI_UF'] : "").'">    
            </div>';
    */
	echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados do Equipamento
        </div>';
		
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Equipamento</label>
				<select id="EQP_CODIGO" name="EQP_CODIGO" '.$disabled1.' required class="form-control1">';
	
		if ( $do == "alt" and $ar1['CLI_CODIGO'] == $ar2['CLI_CODIGO'])
		{
			echo '<option value="'. $ar2['EQP_CODIGO'].'">'.$ar2['EQP_NOME'].'</option>';	
		}
		else
		{	
			echo '<option value="">Selecione</option>';
		}	
					
    if ( !empty($id) )
	{    
		$cQry = " SELECT p.*
				  FROM apl_equipamento p
				  WHERE EQP_STATUS <> 'I' AND p.CLI_CODIGO = ".$ar1['CLI_CODIGO'];

		$rsc  = mysql_query ( $cQry, $conexao );	
			
		while ( $ar = mysql_fetch_assoc( $rsc ) )
		{
			echo '<option value="'. $ar['EQP_CODIGO'].'">'.$ar['EQP_NOME'].' - '.$ar['EQP_MODELO'].' / '.$ar['EQP_SERIE'].'</option>';
		}				     
	}
	echo '  	</select>
			</div>';  	

		/*	
	if ($do == "alt")
	{
		if ( $ar2['EQP_CODIGO'] > 0 )
		{
			$cQry = " SELECT p.*
					  FROM apl_equipamento p
					  WHERE p.EQP_CODIGO = ".$ar2['EQP_CODIGO'];

			$rsc  = mysql_query ( $cQry, $conexao );

			$num = mysql_num_rows( $rsc );	

			if ( $num > 0 )
			{
				$ar = mysql_fetch_assoc( $rsc );

				//Retorna com a resposta
				echo '  <div id="divResultado4" class="form-group">
						<label>Modelo Equipamento</label>
						<input id="EQP_MODELO" name="EQP_MODELO" class="form-control" disabled placeholder="Modelo Equipamento" value="'.$ar['EQP_MODELO'].'">
				  </div>'; 
				  
				 echo '  <div id="divResultado4" class="form-group">
						<label>S&eacute;rie Equipamento</label>
						<input id="EQP_MODELO" name="EQP_SERIE" class="form-control" disabled placeholder="S&eacute;rie Equipamento" value="'.$ar['EQP_SERIE'].'">
				  </div>';  
			}
		}
	}
	else
	{*/
		echo '<div id="divResultado4"></div>';	
	//}
	echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados do Servi&ccedil;o
        </div>';
		
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo de Servi&ccedil;o</label>
				<select id="TPS_CODIGO" name="TPS_CODIGO" required '.$disabled1.' class="form-control1">';
			if ( $do == "alt" and $ar1['CLI_CODIGO'] == $ar2['CLI_CODIGO'])
			{
				echo '<option value="'. $ar2['TPS_CODIGO'].'">'.$ar2['TPS_CODIGOTIPOSER'].'/'.$ar2['TPS_DESCRICAO'].'</option>';	
			}
			else
			{	
				echo '<option value="">Selecione</option>';
			}		
  
	$cQry = " SELECT p.*
			  FROM apl_tpservico p ";

	$rsc  = mysql_query ( $cQry, $conexao );	
			
	
	while ( $ar = mysql_fetch_assoc( $rsc ) )
	{
		echo '<option value="'.$ar['TPS_CODIGO'].'">'.$ar['TPS_CODIGOTIPOSER'].'/'.$ar['TPS_DESCRICAO'].'</option>';
	}				     
	echo '  	</select>
			</div>';  	
			
	echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Operador</label>
                <input class="form-control1" id="USU_CODIGO" required '.$disabled.' name="USU_CODIGO" value="'.($do=="new" ? $_SESSION['ss_nome'] : $ar2['USU_NOME']).'"> 
				<input type="hidden" id="USU_CODIGO" name="USU_CODIGO" value="'.($do <> "alt" ? $_SESSION['ss_codigo'] : $ar2['USU_CODIGO']).'"> 
            </div>'; 	

    echo '  <div id="divResultado1" class="form-group">
				<label for="disabledSelect">Descri&ccedil;&atilde;o do Defeito</label>
				<input type="text" class="form-control" id="ORS_DESCDEFEITO" placeholder="Defeito" '.( $do == "new" ? '' : 'required').' '.($do == "new" ? $disabled1 : "disabled").' name="ORS_DESCDEFEITO" value="'.($do == "alt" ? $ar2['ORS_DESCDEFEITO'] : "").'">
            </div>'; 
			
	if ($do == "alt")
	{
		echo '  <div id="divResultado1" class="form-group">
				<label for="disabledSelect">Servi&ccedil;o do Efetuado</label>
				<textarea class="form-control" rows="5" id="ORS_SERVEXECUTADO" placeholder="Servi&ccedil;o" required name="ORS_SERVEXECUTADO">'.$ar2['ORS_SERVEXECUTADO'].'</textarea>
            </div>'; 

		if ($num3  > 0)
		{
			while ( $ar3 = mysql_fetch_assoc( $rsc3 ) )
			{
				echo '  <div class="form-group">
							<div><label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Atendimento&nbsp;</label>
							<input class="form-control5" id="COM_DATA" required '.$disabled.' name="COM_DATA" value="'.Stod($ar3['COM_DATA']).'"> 
							<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">&nbsp;Hora Inicial&nbsp;</label><input class="form-control5" id="COM_HRINICIO" '.$disabled.' name="COM_HRINICIO" value="'.$ar3['COM_HRINI'].'">
							<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">&nbsp;Hora Final&nbsp;</label>
							<input class="form-control5" id="COM_HRFIM" '.$disabled.' name="COM_HRFIM" value="'.$ar3['COM_HRFIM'].'">&nbsp;
							<button type="submit" id="not" name="not"  class="btn btn-default">+</button>&nbsp;<button type="submit" id="del" name="del"  class="btn btn-default">-</button></div> 
							<input type="hidden" id="ORS_CODIGO" name="ORS_CODIGO" value="'.$id.'">
							<input type="hidden" id="COM_CODIGO" name="COM_CODIGO" value="'.$ar3['COM_CODIGO'].'">
						</div>';  
			}	
		}	
		
		if ( $num3  <= 0 || $op == "outro")
		{	
			echo '  <div class="form-group">
					<div><label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Atendimento&nbsp;</label>
					<input class="form-control5" id="COM_DATA" required '.$disabled1.' name="COM_DATA" value="'.date('d').'/'.date('m').'/'.date('Y').'"> 
					<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">&nbsp;Hora Inicial&nbsp;</label><input class="form-control5" id="COM_HRINICIO" '.$disabled1.' name="COM_HRINICIO" value="'.date('H').':'.date('i').'">
					<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">&nbsp;Hora Final&nbsp;</label>
                    <input class="form-control5" id="COM_HRFIM" '.$disabled1.' name="COM_HRFIM" value="">&nbsp;
					<button type="submit" id="add" name="add" class="btn btn-default">+</button>&nbsp;<button type="submit" id="notdel" name="notdel" class="btn btn-default">-</button></div> 
					<input type="hidden" id="ORS_CODIGO" name="ORS_CODIGO" value="'.$id.'">
				</div>';  
		}
	}	
 			    
    echo '<button type="submit" id="salvar" name="salvar" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
                </div>';		

}
elseif ( $do == "inc" || $do == "exc" )
{   
	if ( $do == "inc" )
	{
		$disabled1 = "disabled";
		$disabled2 = "";
		$disabled = "disabled";
		$cQry2 = "SELECT os.*, p.*, e.EQP_NOME, tp.* , usu.*
		         FROM apl_ordemservico os 
                      inner join apl_cliente p on os.CLI_CODIGO = p.CLI_CODIGO
					  inner join apl_equipamento e on e.EQP_CODIGO = os.EQP_CODIGO 
					  inner join apl_tpservico tp on tp.TPS_CODIGO = os.TPS_CODIGO
					  inner join apl_usuario usu on usu.USU_CODIGO = os.USU_CODIGO
 				 WHERE os.ORS_CODIGO = ".$id;
				 
		$rsc2  = mysql_query ( $cQry2, $conexao );			
        $ar2 = mysql_fetch_assoc( $rsc2 );	
	}
	else
	{
		$disabled1 = "disabled";
		$disabled2 = "";	
	}
	echo '<div class="col-lg-6">
		  <h2>'.( $do == 'inc' ? 'Inclus&atilde;o de Complemento' : '' ).'</h2>
		  <div class="table-responsive">';
		  
    echo '<form method="post" action="gravarbanco.php?url=os&do='.$do.'" id="formcad" name="formcad">';
	
	echo '  <div class="form-group input-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Chamado</label>
                <input type="text" class="form-control" '.$disabled.'  name="ORS_NUMERO" id="ORS_NUMERO" value="'.( str_pad($ar2['ORS_CODIGO'], 12, "0", STR_PAD_LEFT)).'">
            </div>';
	
	
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Abertura</label>
                <input class="form-control1" id="ORS_DTINICIO" required '.$disabled1.' name="ORS_DTINICIO" value="'.(Stod($ar2['ORS_DTINICIO'])).'"> 
            </div>'; 	
			
	echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Hora Abertura</label>
                <input class="form-control1" id="ORS_HORAINICIO" required '.$disabled1.' name="ORS_HORAINICIO" value="'.($ar2['ORS_HORAINICIO']).'"> 
            </div>'; 		
			  
    
    echo '  <div class="form-group input-group">
                <input type="text" class="form-control" '.$disabled1.' required placeholder="Nome do Cliente" name="CLI_NOME" id="CLI_NOME" value="'.$ar2['CLI_NOME'] .'">
 				<span class="input-group-btn">
                  <button class="btn btn-default" id="cliente" name="cliente" type="button"><i class="fa fa-search"></i></button>
                </span>    
              </div>';
             
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Endere&ccedil;o</label>
                <input class="form-control" required id="CLI_ENDERECO" '.$disabled.' placeholder="Rua, Avenida, Estrada" name="CLI_ENDERECO" value="'.$ar2['CLI_ENDERECO'].'">
                <input class="form-control" id="CLI_CIDADE" '.$disabled.' placeholder="Cidade" name="CLI_CIDADE" value="'. $ar2['CLI_CIDADE'].'">
                <input class="form-control" id="CLI_TELEFONE" '.$disabled.' placeholder="Telefone" name="CLI_TELEFONE" value="'.$ar2['CLI_TELEFONE'].'">
                <input class="form-control" id="CLI_UF" '.$disabled.' placeholder="UF" name="CLI_UF" value="'.$ar2['CLI_UF'].'">    
            </div>';
    
		
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Equipamento</label>
				<select id="EQP_CODIGO" name="EQP_CODIGO" '.$disabled1.' required class="form-control1" onchange="setarCampos4(this); enviarForm(\'processar4.php\', campos, \'divResultado4\'); return false;">';
	echo '<option value="'. $ar2['EQP_CODIGO'].'">'.$ar2['EQP_NOME'].'</option>';	

	echo '  	</select>
			</div>';  	

	$cQry = " SELECT p.*
			  FROM apl_equipamento p
			  WHERE p.EQP_CODIGO = ".$ar2['EQP_CODIGO'];

	$rsc  = mysql_query ( $cQry, $conexao );

	$num = mysql_num_rows( $rsc );	

	if ( $num > 0 )
	{
		$ar = mysql_fetch_assoc( $rsc );

		//Retorna com a resposta
		echo '  <div id="divResultado4" class="form-group">
				<label>Modelo Equipamento</label>
				<input id="EQP_MODELO" name="EQP_MODELO" class="form-control" disabled placeholder="Modelo Equipamento" value="'.$ar['EQP_MODELO'].'">
		  </div>'; 
		  
		 echo '  <div id="divResultado4" class="form-group">
				<label>S&eacute;rie Equipamento</label>
				<input id="EQP_MODELO" name="EQP_SERIE" class="form-control" disabled placeholder="S&eacute;rie Equipamento" value="'.$ar['EQP_SERIE'].'">
		  </div>';  
	}
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo de Servi&ccedil;o</label>
				<select id="TPS_CODIGO" name="TPS_CODIGO" required '.$disabled1.' class="form-control1">';
	echo '<option value="'. $ar2['TPS_CODIGO'].'">'.$ar2['TPS_CODIGOTIPOSER'].'/'.$ar2['TPS_DESCRICAO'].'</option>';				     
	echo '  	</select>
			</div>';  	
			
	echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Operador</label>
                <input class="form-control1" id="USU_CODIGO" required '.$disabled.' name="USU_CODIGO" value="'. $ar2['USU_NOME'].'"> 
	        </div>'; 	

    echo '  <div id="divResultado1" class="form-group">
				<label for="disabledSelect">Descri&ccedil;&atilde;o do Defeito</label>
				<textarea class="form-control" id="ORS_DESCDEFEITO" placeholder="Defeito" '.$disabled2.' name="ORS_DESCDEFEITO">'. $ar2['ORS_DESCDEFEITO'].'</textarea>
            </div>'; 
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Dados do Complemento
        </div>';	
	
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo Complemento</label>
				<select id="COM_TIPO" name="COM_TIPO" required '.$disabled2.' class="form-control1" onchange="setarCampos3(this); enviarForm(\'processar3.php\', campos, \'divResultado3\'); return false;">
					<option value="S">Servi&ccedil;o</option>';
				if ( $_SESSION['ss_perfil']=='A')
				{	
					echo '<option value="V">Viagem</option>';
				}	
	echo '  	</select>
			</div>';  	
				
    echo '<div id="divResultado3"></div>';	
	
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Data Abertura</label>
                <input class="form-control1" id="COM_DATA" required '.$disabled2.' name="COM_DATA" value="'.date('d').'/'.date('m').'/'.date('Y').'"> 
				<input type="hidden" id="ORS_CODIGO" name="ORS_CODIGO" value="'.$id.'">
            </div>';  	
			
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo Hora</label>
				<select id="COM_TPHORA" name="COM_TPHORA" required '.$disabled2.' class="form-control1">
					<option value="C">Comercial</option>';
				if ( $_SESSION['ss_perfil']=='A')
				{		
					echo '<option value="E">Extra</option>';
				}	
	echo '  	</select>
			</div>';  			
			
	echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Hora Inicial</label>
                <input class="form-control1" id="COM_HRINICIO" required '.$disabled2.' name="COM_HRINICIO" value="'.date('H').':'.date('i').'"> 
            </div>'; 
	
	echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Hora Final</label>
                <input class="form-control1" id="COM_HRFIM" required '.$disabled2.' name="COM_HRFIM" value=""> 
            </div>'; 	
			
	
    echo '  <div id="divResultado1" class="form-group">
				<label for="disabledSelect">Descri&ccedil;&atilde;o Complemento</label>
				<textarea class="form-control" id="COM_DESCRICAO" placeholder="Descri&ccedil;&atilde;o Complemento" '.$disabled2.' name="COM_DESCRICAO"></textarea>
            </div>'; 
        
    echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
                </div>';		

}
elseif ( $do == "dep" )
{   
	if ( $do == "dep" )
	{
		$disabled1 = "";
	}
	else
	{
		$disabled1 = "disabled";	
	}
	echo '<div class="col-lg-6">
		  <h2>'.( $do == 'dep' ? 'Depesas da O.S.' : '' ).'</h2>
		  <div class="table-responsive">';
		  
    echo '<form method="post" action="gravarbanco.php?url=os&do='.$do.'" id="formcad" name="formcad">';
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Despesas da O.S.
        </div>';	
	
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Despesa</label>
				<select id="DEP_CODIGO" name="DEP_CODIGO" '.$disabled1.' required class="form-control1">
					<option value="">Selecione</option>';
					
    if ( !empty($id) )
	{    
		$cQry = " SELECT p.*
				  FROM apl_tipodespesa p ";

		$rsc  = mysql_query ( $cQry, $conexao );					
		
		while ( $ar = mysql_fetch_assoc( $rsc ) )
		{
			echo '<option value="'.$ar['TIP_CODIGO'].'">'.$ar['TIP_DESCRICAO'].'</option>';
		}				     
	}
	echo '  	</select>
			</div>';  			
	
    echo '  <div class="form-group">
                <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Valor</label>
                <input class="form-control1" id="DEP_VALOR" name="DEP_VALOR" required '.$disabled1.' value=""> 
				<input type="hidden" id="ORS_CODIGO" name="ORS_CODIGO" value="'.$id.'">
            </div>';  	
			        
    echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
          </div>';		

}

elseif ( $do == "pec" )
{   
	if ( $do == "pec" )
	{
		$disabled1 = "";
	}
	else
	{
		$disabled1 = "disabled";	
	}
	echo '<div class="col-lg-6">
		  <h2>'.( $do == 'dep' ? 'Pe&ccedil;as da O.S.' : '' ).'</h2>
		  <div class="table-responsive">';
		  
    echo '<form method="post" action="gravarbanco.php?url=os&do='.$do.'" id="formcad" name="formcad">';
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Pe&ccedil;as da O.S.
        </div>';	
	
	echo '  <div class="form-group">
				<label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Pe&ccedil;as</label>
				<input type="hidden" id="ORS_CODIGO" name="ORS_CODIGO" value="'.$id.'">	
				<select id="PEC_CODIGO" name="PEC_CODIGO" '.$disabled1.' required class="form-control1">
					<option value="">Selecione</option>';
					
    if ( !empty($id) )
	{    
		$cQry = " SELECT p.*
				  FROM apl_pecas p ";

		$rsc  = mysql_query ( $cQry, $conexao );					
		
		while ( $ar = mysql_fetch_assoc( $rsc ) )
		{
			echo '<option value="'.$ar['PEC_CODIGO'].'">'.$ar['PEC_DESCRICAO'].'/'.$ar['PEC_CODIGOPEC'].'</option>';
		}				     
	}
	echo '  	</select>
			</div>';  			
			        
    echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
    
    if ( $do != 'view' )
    {
        echo '<button type="reset" class="btn btn-default">Limpar</button>';  			
    }    
    echo '</form>';	

    echo '	</div>
          </div>';		

}
elseif ( $do == "fec" )
{
    ?>  
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-backward"></i> Voltar</a></li>
    </ol>	
	
    <?php	
	
	if (isset($_POST['CLIENTE']))	
	{
		$clientec = $_POST['CLIENTE'];
	}
	else
	{
		$clientec = "";
	}
	
	if (isset($_POST['EQP']))	
	{
		$eqpc = $_POST['EQP'];
	}
	else
	{
		$eqpc = "";
	}

	$cQry = " SELECT os.*,c.CLI_NOME, s.TPS_CODIGOTIPOSER, s.TPS_DESCRICAO, 
	                 e.EQP_NOME, e.EQP_MODELO, u.USU_NOME
              FROM apl_ordemservico os
					INNER JOIN apl_cliente c
					ON os.cli_codigo = c.cli_codigo 
					INNER JOIN apl_tpservico s
					ON os.TPS_CODIGO = s.TPS_CODIGO	
					INNER JOIN apl_equipamento e
					ON os.EQP_CODIGO = e.EQP_CODIGO	
					INNER JOIN apl_usuario u
					ON os.USU_CODIGO = u.USU_CODIGO
			  WHERE os.ORS_STATUS <> 'F'	";
			  
	if (!empty($clientec))
	{
		$cQry .= " AND os.CLI_CODIGO = '".$clientec."' ";	
	}
	
	if (!empty($eqpc))
	{
		$cQry .= " AND os.EQP_CODIGO = '".$eqpc."' ";	
	}		  
			  
    $cQry .= "ORDER BY os.ORS_NUMERO ASC ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     	
    if ( $num > 0 )
    {
		$cQrycc = " SELECT p.*
			        FROM apl_cliente p ";

		$rsccc  = mysql_query ( $cQrycc, $conexao );
	
		
		$cQryeq = " SELECT e.*
					FROM apl_equipamento e ";

		$rsceq  = mysql_query ( $cQryeq, $conexao );

		
		echo '<form method="post" action="index.php?url=os&do=fec" id="formcad" name="formcad">';
		echo '<table style="border: 1px solid #ccc" align=center width=40%><tr><td colspan=2 align=center><b>Filtros</b></td></tr>
					<tr><td colspan=2 align=center><a id="exibir"><b>Exibir </b></a><b><a id="esconder">Ocultar</a></b>
				</td></tr></table>';
		echo ' <div id="MeuDiv"><table align=center style="border: 1px solid #ccc" width=40% CELLSPACING=2 CELLPADDING=4>
			
			
			
			<tr><td width="32%"><b>Cliente:</b></td>	
			    <td><select id="CLIENTE" name="CLIENTE" class="form-control7">
					<option value=""></option>';
	
			while ( $arcc = mysql_fetch_assoc( $rsccc ) )
			{
				echo '<option value="'.$arcc['CLI_CODIGO'].'">'.$arcc['CLI_NOME'].($arcc['CLI_STATUS'] == 'I' ? ' - Inativo' : '').'</option>';
			}
	
			echo '</select></td></tr>
	
			<tr><td width="32%"><b>Equipamento:</b></td>	
							<td><select id="EQP" name="EQP" class="form-control7">
								<option value=""></option>';
				
			while ( $areq = mysql_fetch_assoc( $rsceq ) )
			{
				echo '<option value="'.$areq['EQP_CODIGO'].'">'.$areq['EQP_NOME'].'-'.$areq['EQP_SERIE'].($areq['EQP_STATUS'] == 'I' ? ' - Inativo' : '').'</option>';
			}
		
			echo '</select></td></tr>	
						
			<tr><td align=center colspan=2><button type="submit" class="btn btn-default">Filtrar</button><br></td></tr></table></form>';
			
			
	
	echo '</table></div>';
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
						<th></th>
                        <th>Chamado <i class="fa fa-sort"></i></th>
                        <th>Cliente <i class="fa fa-sort"></i></th>		
                        <th>Servi&ccedil;o <i class="fa fa-sort"></i></th>  
                        <th>Horas Trabalhadas <i class="fa fa-sort"></i></th> 
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
		
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
		
			$cQryDep = "SELECT SUM(DES_VALOR) AS TOTAL FROM apl_despesas WHERE ORS_CODIGO = '".$ar['ORS_CODIGO']."' ";
			$rscDep = mysql_query( $cQryDep, $conexao );
			$arDep = mysql_fetch_assoc( $rscDep );
			
			$totaldesp = $arDep['TOTAL'];
			
			$cQryCOM = "SELECT COM_HRFIM, COM_HRINI FROM apl_complemento WHERE ORS_CODIGO = '".$ar['ORS_CODIGO']."'";
			$rscCOM = mysql_query( $cQryCOM, $conexao );
			
			$i = 0; 
			$horatotal = 0;	
			while( $arCOM = mysql_fetch_assoc( $rscCOM ))
			{	
				$h_inicial = strtotime($arCOM['COM_HRINI']) / 60;
				$h_final = strtotime($arCOM['COM_HRFIM']) / 60;
				$diferenca = $h_final - $h_inicial;
				$horatotal = $horatotal + $diferenca;
				
				$i++;
			}
			
			/*
			$cQryEXT = "SELECT COM_HRFIM, COM_HRINI FROM apl_complemento WHERE ORS_CODIGO = '".$ar['ORS_CODIGO']."' AND COM_TPHORA = 'E'";
			$rscEXT = mysql_query( $cQryEXT, $conexao );
			
			$i = 0; 	
			$horatotal = 0;
			while( $arCOM = mysql_fetch_assoc( $rscEXT ))
			{	
				$h_inicial = strtotime($arEXT['COM_HRINI']) / 60;
				$h_final = strtotime($arEXT['COM_HRFIM']) / 60;
				$diferenca = $h_final - $h_inicial;
				$horatotal = $horatotal + $diferenca;
				$i++;
			}
			*/
            echo '<tr>
						<td><input type="checkbox" name="op" id="op" value="'.$ar['ORS_CODIGO'].'"> </td>
                        <td>'.$ar['ORS_NUMERO'].'</td>
                        <td>'.$ar['CLI_NOME'].'</td>
                        <td>'.$ar['TPS_CODIGOTIPOSER'].'/'.$ar['TPS_DESCRICAO'].'</td>						
                        <td align=center>'.mintohora($horatotal).'</td>
 	
                  </tr>';	  
        }
		if ( $do == 'fec' )
		{
			echo ' <tr><td colspan=7 align=right><button type="button" onclick="Fec()" class="btn btn-default">Fechar O.S.</button>
		</td></tr>';
		}
		echo '</tbody>
              </table>';
	}
}
elseif ( $do == "rel" )
{
    ?>  
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-backward"></i> Voltar</a></li>
    </ol>	
	
    <?php	
	if (isset($_POST['CONSULTA']))	
	{
		$consulta = $_POST['CONSULTA'];
	}
	else
	{
		$consulta = "";
	}
    
	if (isset($_POST['CLIENTE']))	
	{
		$clientec = $_POST['CLIENTE'];
	}
	else
	{
		$clientec = "";
	}
	
	if (isset($_POST['EQP']))	
	{
		$eqpc = $_POST['EQP'];
	}
	else
	{
		$eqpc = "";
	}
	$cQry = " SELECT os.*,c.CLI_NOME, s.TPS_CODIGOTIPOSER, s.TPS_DESCRICAO, 
	                 e.EQP_NOME, e.EQP_MODELO, u.USU_NOME
              FROM apl_ordemservico os
					INNER JOIN apl_cliente c
					ON os.cli_codigo = c.cli_codigo 
					INNER JOIN apl_tpservico s
					ON os.TPS_CODIGO = s.TPS_CODIGO	
					INNER JOIN apl_equipamento e
					ON os.EQP_CODIGO = e.EQP_CODIGO	
					INNER JOIN apl_usuario u
					ON os.USU_CODIGO = u.USU_CODIGO ";
	if (!empty($consulta))
	{	
		$cQry .= "WHERE os.ORS_STATUS = '".$consulta."' ";	
	}	
	else
	{
		$cQry .= "WHERE os.ORS_STATUS <> 'F' ";	
	}

	if (!empty($clientec))
	{
		$cQry .= " AND os.CLI_CODIGO = '".$clientec."' ";	
	}
	
	if (!empty($eqpc))
	{
		$cQry .= " AND os.EQP_CODIGO = '".$eqpc."' ";	
	}
	
	if ($_SESSION['ss_perfil']=='O')
	{
		$cQry .= " AND os.USU_CODIGO = '".$_SESSION['ss_codigo']."' ";	
	}
	
    $cQry .= " ORDER BY os.ORS_NUMERO ASC ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
	
	$cQrycc = " SELECT p.*
			    FROM apl_cliente p  ";

	$rsccc  = mysql_query ( $cQrycc, $conexao );
	
	
	$cQryeq = " SELECT e.*
			    FROM apl_equipamento e  ";

	$rsceq  = mysql_query ( $cQryeq, $conexao );

	
	
	  echo '<form method="post" action="index.php?url=os&do=acomp" id="formcad" name="formcad">';
	echo '<table style="border: 1px solid #ccc" align=center width=40%><tr><td colspan=2 align=center><b>Filtros</b></td></tr>
					<tr><td colspan=2 align=center><a id="exibir"><b>Exibir </b></a><b><a id="esconder">Ocultar</a></b>
	</td></tr></table>';
	echo ' <div id="MeuDiv"><table align=center style="border: 1px solid #ccc" width=40% CELLSPACING=2 CELLPADDING=4>
			
			
			
			<tr><td width="32%"><b>Cliente:</b></td>	
			    <td><select id="CLIENTE" name="CLIENTE" onchange="buscar_cidades()" class="form-control7">
					<option value="">Selecione o cliente</option>';
	
			while ( $arcc = mysql_fetch_assoc( $rsccc ) )
			{
				echo '<option value="'.$arcc['CLI_CODIGO'].'">'.$arcc['CLI_NOME'].'</option>';
			}
	
			echo '</select></td></tr>
	
			<tr><td width="32%"><b>Equipamento:</b></td>	
							<td><div id="load_cidades"><select id="EQP" name="EQP" class="form-control7">
								<option value="">Selecione o equipamento</option>';
								
				
			echo '</select></td></tr>
				
			
			<tr><td align=center colspan=2><button type="button" onclick="abrir4()" class="btn btn-default">Gerar</button></td></tr></table></form>';
			
			
	
	echo '</table></div>';
  
}
/*
elseif ( $do == "grafico" )
{
    ?>  
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-backward"></i> Voltar</a></li>
    </ol>	
	
    <?php	
	
	$cQry = " SELECT COM_HRFIM, COM_HRINI, COM_DATA, os.ORS_CODIGO, USU_LOGIN 
			  FROM apl_complemento co
					inner join apl_ordemservico os on
					 co.ORS_CODIGO = os.ORS_CODIGO
					inner join apl_usuario usu on
					 usu.USU_CODIGO = os.USU_CODIGO ";
	
    $cQry .= " ORDER BY usu.USU_LOGIN ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
	
	$h_inicial = 0;	
	$h_final = 0;
	$diferenca = 0;
	$horatotal = 0;
	$aux = '';
	$i = 0;
	
	
	while ( $ar = mysql_fetch_assoc( $rsc ) )
    {	
		
		if (($aux == $ar['USU_LOGIN']) or ($aux == ''))
		{	
			$h_inicial = strtotime($ar['COM_HRINI']) / 60;
			$h_final = strtotime($ar['COM_HRFIM']) / 60;
			$diferenca = $h_final - $h_inicial;
			$horatotal = $horatotal + $diferenca;
		}
		else
		{
			$dados = array(
						array($ar['USU_LOGIN'], $horatotal));	
			$h_inicial = 0;	
			$h_final = 0;
			$diferenca = 0;
			$horatotal = 0;
		}
		$aux = $ar['USU_LOGIN'];		
	}
	
	$dados = array(
				array($ar['USU_LOGIN'], $horatotal));
	$plot = new PHPlot(400,200); //defini as dimensões do grafico
	$plot->SetTitleColor('#404040'); // Cor do titulo do grafico
	$plot->SetTitle('Total de Reclamacoes – Usuario'); // titulo do Grafico

	#$plot->SetFileFormat(“png”); //seleciona o formato de saida do grafico
	$plot->SetImageBorderType('plain');

	#$plot->SetBackgroundColor(‘YellowGreen’); // Define a cor de fundo do grafico

	$plot->SetPlotType('pie'); // Seleciona o tipo do grafico, pode ser PIE, BARS, LINES e etc

	$plot->SetDataType('text-data-single');

	$plot->SetDataValues($dados);

	foreach ($dados as $row) $plot->SetLegend($row[0]);

	$plot->DrawGraph(); //gera o grafico
}
*/

elseif ( $do == "cliente" || $do == "cliente1" || $do == "cliente2" )
{

    echo '<ol class="breadcrumb">
            <li><a href="index.php?url=os&do='.( $do == "cliente" ? "new" : "alt"  ).'"><i class="fa fa-backward"></i> Voltar</a></li>
          </ol>';
    
    echo '<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Selecione o '.( $do == "cliente" ? "new" : "solicitante" ).'
        </div>';
    
    $cQry = " SELECT LPAD(p.CLI_CODIGO,6,'0') as CODIGO, p.*
              FROM apl_cliente p 
			  WHERE CLI_STATUS <> 'I' ";

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

function mintohora($minutos)
{
	$hora = floor($minutos/60);
	$resto = $minutos%60;

	if (strlen($resto) == 1)
	{
		$resto = '0'.$resto; 
	} 
	return $hora.':'.$resto;
}
?>
<script>
//Cria a função com os campos para envio via parâmetro
function setarCampos3() {
    campos = "dados="+encodeURI(document.getElementById('COM_TIPO').value);
}
function setarCampos4() {
    campos = "dados="+encodeURI(document.getElementById('EQP_CODIGO').value);
}
function chamarform( op ) {
    var tp;

    if ( op == "new" )
    {
        tp = "cliente";
    }
    else if ( op == "alt")
    {
        tp = "cliente2";
    }
	else
	{
		tp = "cliente1";
	}
    location.href="index.php?url=os&do="+tp;
}

function voltaform( op, id ) {
    var tp;
    if ( op == "cliente" )
    {
        tp = "new";
    }
	else if ( op == "cliente2" )
	{
		tp = "alt";
	}
    else 
    {
        tp = "solicitante";
    }
    location.href="index.php?url=os&do="+tp+"&id="+id;
}
function Inc(){
	var aChk = document.getElementsByName("op");  
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
	if (op >= 1)
	{
		location.href="index.php?url=os&do=inc&id="+op;
	}
	else
	{
		alert('Selecione um chamado!');	
	}	
}
function Exc(){
	var decisao;
	var aChk = document.getElementsByName("op");  
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
		
	if (op >= 1)
	{
		decisao = confirm("Deseja realmente excluir a O.S.?");
		if (decisao){
			location.href="gravarbanco.php?url=os&do=del&id="+op;	
		} 
	}
	else
	{
		alert('Selecione um chamado!');
	}	
}
function Alt(){
	var decisao;
	var aChk = document.getElementsByName("op");  
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
		
	if (op >= 1)
	{
		location.href="index.php?url=os&do=alt&id1="+op;	
	}
	else
	{
		alert('Selecione um chamado!');
	}	
}
function Fec(){
	var decisao;
	var aChk = document.getElementsByName("op");  
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
		
	if (op >= 1)
	{
		decisao = confirm("Deseja realmente fechar a O.S.?");
		if (decisao){
			location.href="gravarbanco.php?url=os&do=fec&id="+op;	
		} 
	}
	else
	{
		alert('Selecione um chamado!');
	}	
}
function Vis(){
	var aChk = document.getElementsByName("op"); 
	
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
	if (op >= 1)
	{
		location.href="index.php?url=os&do=vis&id="+op;
	}
	else
	{
		alert('Selecione um chamado!');
	}	
}
function Dep(){
	var aChk = document.getElementsByName("op"); 
	
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
	if (op >= 1)
	{
		location.href="index.php?url=os&do=dep&id="+op;
	}
	else
	{
		alert('Selecione um chamado!');
	}	
}
function Pec(){
	var aChk = document.getElementsByName("op"); 
	
	for (var i=0;i<aChk.length;i++){  
		if (aChk[i].checked == true){  
			op = aChk[i].value;
			break;
		} 
	}
	if (op >= 1)
	{
		location.href="index.php?url=os&do=pec&id="+op;
	}
	else
	{
		alert('Selecione um chamado!');
	}	
}
function abrir3() {
    var aChk = document.getElementsByName("op"); 
	
    for (var i=0;i<aChk.length;i++){  
            if (aChk[i].checked == true){  
                    op = aChk[i].value;
                    break;
            } 
    }
    if (op >= 1)
    {
        var left = 0;
        var top = 0;

        window.open('rel_os.php?id='+op,'janela', 'top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

    }
    else
    {
            alert('Selecione um chamado!');
    } 
  
}
function abrir4() {
    var cliente = document.getElementById("CLIENTE").value; 
	var eqp = document.getElementById("EQP").value;	
	
	var left = 0;
	var top = 0;

	window.open('relatorio.php?cli='+cliente+'&eqp='+eqp,'janela', 'top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

    
}
</script>
	  </div>
    </div>
</div> 
