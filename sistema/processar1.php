<?php
include ('conexao.php');

//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $servico; 

$cQry = " SELECT p.*
          FROM servico p
          WHERE p.TIP_CODIGO = ".$codigo;

$rsc  = mysql_query ( $cQry, $conexao );


//Retorna com a resposta
echo '  <div id="divResultado" class="form-group">
           <label>Servi&ccedil;o</label>
           <select id="SER_CODIGO" name="SER_CODIGO" class="form-control1" onchange="setarCampos2(this); enviarForm(\'processar2.php\', campos, \'divResultado1\'); return false;">
           <option>Selecione</option>';

while ( $ar = mysql_fetch_assoc( $rsc ) )
{
    echo '<option value="'.$ar['SER_CODIGO'].'">'.$ar['SER_DESCRICAO'].'</option>';
}
                  
echo '  </select>
      </div>'; 

if ( $codigo == 1 )
{
    echo '<div id="divResultado" class="form-group">
           <label>Termo/Matr&iacute;cula</label>
           <input id="SER_TERMO" name="ITM_TERMO" placeholder="Termo da certid&atilde;o" value="" class="form-control1">
          </div>';    
    
    echo '<div id="divResultado" class="form-group">
           <label>Folha</label>
           <input id="SER_FOLHA" name="ITM_FOLHA" placeholder="Folha da certid&atilde;o" value="" class="form-control1">
          </div>';  
    
    echo '<div id="divResultado" class="form-group">
           <label>Livro</label>
           <input id="SER_LIVRO" name="ITM_LIVRO" value="" placeholder="Livro da certid&atilde;o" class="form-control1">
          </div>';  
    
    echo '<div id="divResultado" class="form-group">
           <label>Cart&oacute;rio</label>
           <input id="SER_CARTORIO" name="ITM_CARTORIO" value="" placeholder="Cart&oacute;rio da certid&atilde;o" class="form-control1">
          </div>';  
}

?>
