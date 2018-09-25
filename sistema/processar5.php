<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados;

if ( $codigo != '4' )
{
    //Retorna com a resposta
    $cQry = " SELECT p.*
              FROM contascorrentes p ";

    $rsc  = mysql_query ( $cQry, $conexao );

    //Retorna com a resposta
    echo '  <div id="divResultado" class="form-group">
            <label>Contas Correntes</label>
            <select id="CCO_CODIGO" name="CCO_CODIGO" class="form-control1">
            <option>Selecione</option>';

    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['CCO_CODIGO'].'">'.$ar['CCO_DESCRICAO'].'</option>';
    }

    echo '  </select>
        </div>'; 
    
}
?>
