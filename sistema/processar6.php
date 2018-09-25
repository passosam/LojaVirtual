<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados;

if ( $codigo == 'N' )
{    
    //Retorna com a resposta
    $cQry = " SELECT p.*
              FROM uf p ";

    $rsc  = mysql_query ( $cQry, $conexao );

    //Retorna com a resposta
    echo '  <div id="divResultado" class="form-group">
            <label>UF</label>
            <select id="SEP_UF" name="SEP_UF" class="form-control1">
            <option>Selecione</option>';

    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['UF_SIGLA'].'">'.$ar['UF_SIGLA'].'</option>';
    }

    echo '  </select></div>'; 
    
}
?>
