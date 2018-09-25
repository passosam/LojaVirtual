<?php
session_start();
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados; 
$disabled = "disabled";

$cQry = " SELECT p.*
          FROM servico p
          WHERE p.SER_CODIGO = ".$codigo;

$rsc  = mysql_query ( $cQry, $conexao );

$ar = mysql_fetch_assoc( $rsc );
$_SESSION['ss_servico'] = $codigo;

if ( $ar['SER_PRECO'] > 0 )
{
    echo '<div id="divResultado1" class="form-group">
            <label for="disabledSelect">Valor</label>
            <input class="form-control1" id="SER_PRECO" placeholder="Valor do servi&ccedil;o" name="SER_PRECO" '.$disabled.' value="'.number_format($ar['SER_PRECO'], 2, ",",".").'">
            <input type="hidden" id="MOV_VALOR" name="MOV_VALOR" value="'.$ar['SER_PRECO'].'">    
          </div>';  
}

if ( $codigo == 1  )
{
    echo ' <div class="form-group">
                <label for="disabledSelect">Regi&atilde;o do Documento</label>
                <select id="SEP_TIPO" name="SEP_TIPO"  onchange="setarCampos6(this); enviarForm(\'processar7.php\', campos, \'divResultado8\'); return false;" class="form-control1">
                    <option value="">Selecione</option>
                    <option value="L">Local</option>
                    <option value="E">Estadual</option>
                    <option value="N">Nacional</option>';
    echo '  </select>
            </div>';

}
?>
