<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados;

if ( substr($codigo, 0, 1) == 'N' )
{    
    //Retorna com a resposta
    $cQry = " SELECT p.*
              FROM uf p ";

    $rsc  = mysql_query ( $cQry, $conexao );

    //Retorna com a resposta
    echo '  <div id="divResultado8" class="form-group">
            <label>UF</label>
            <select id="SEP_UF" name="SEP_UF" onchange="setarCampos7(this); enviarForm(\'processar8.php\', campos, \'divResultado9\'); return false;" class="form-control1">
            <option>Selecione</option>';

    while ( $ar = mysql_fetch_assoc( $rsc ) )
    {
        echo '<option value="'.$ar['UF_SIGLA'].'">'.$ar['UF_SIGLA'].'</option>';
    }

    echo '  </select></div>'; 
    
}
else
{
    //Retorna com a resposta
    $cQry = " SELECT p.*
            FROM servpreco p
            WHERE concat(SEP_TIPO,SER_CODIGO) = '".$codigo."'" ;

    $rsc  = mysql_query ( $cQry, $conexao );

    $ar = mysql_fetch_assoc( $rsc );

    //Retorna com a resposta
    echo '  <div id="divResultado7" class="form-group">
            <label>Pre&ccedil;o</label>
            <input id="MOV_VALOR" name="MOV_VALOR" class="form-control1" disabled  value="'.number_format($ar['SEP_PRECO'], 2, ",", ".").'">
            <input type="hidden" id="MOV_VALOR" name="MOV_VALOR" class="form-control1" value="'.$ar['SEP_PRECO'].'">    
        </div>';     
}

?>
