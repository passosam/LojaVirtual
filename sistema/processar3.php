<?php
//Determina o tipo da codifica��o da p�gina
header("content-type: text/html; charset=iso-8859-1"); 

//Extrai os dados do formul�rio
extract($_GET); 

$codigo = $dados;

if ( $codigo <> 'S' )
{
	echo '<div id="divResultado3" class="form-group">
		<label>Qtd. Km</label>
        <input id="COM_KM" name="COM_KM" class="form-control1" value="">    
      </div>'; 

}
?>
