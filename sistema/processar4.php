<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados;

if ( $codigo > 0 )
{
	$cQry = " SELECT p.*
			  FROM apl_equipamento p
			  WHERE p.EQP_CODIGO = ".$codigo;

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
?>
