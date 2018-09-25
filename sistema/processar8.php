<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados;

//Retorna com a resposta
$cQry = " SELECT p.*
          FROM servpreco p
          WHERE concat(SEP_UF,SER_CODIGO) = '".$codigo."'" ;

$rsc  = mysql_query ( $cQry, $conexao );

$ar = mysql_fetch_assoc( $rsc );

//Retorna com a resposta
echo '  <div id="divResultado7" class="form-group">
        <label>Pre&ccedil;o</label>
        <input id="MOV_VALOR" name="MOV_VALOR" class="form-control1" disabled  value="'.number_format($ar['SEP_PRECO'], 2, ",", ".").'">
        <input type="hidden" id="MOV_VALOR" name="MOV_VALOR" class="form-control1" value="'.$ar['SEP_PRECO'].'">    
    </div>'; 

 
?>
