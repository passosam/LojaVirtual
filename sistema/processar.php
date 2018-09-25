<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $uf; 



$cQry = " SELECT p.*
          FROM cidade p
          WHERE p.UF_CODIGO = ".$codigo;

$rsc  = mysql_query ( $cQry, $conexao );


//Retorna com a resposta
echo '  <div id="divResultado3" class="form-group">
           <label>Cidade</label>
           <select id="CID_CODIGO" name="CID_CODIGO" class="form-control1">';

while ( $ar = mysql_fetch_assoc( $rsc ) )
{
    echo '<option value="'.$ar['CID_CODIGO'].'">'.$ar['CID_NOME'].'</option>';
}
                  
echo '  </select>
      </div>'; 

?>
