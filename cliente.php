<?php

include('conexao.php');

echo '<div id="cab13">
		<img src="image/cliente/cliente.png" border="0">
	  </div>';

echo '<div id="cab14">CLIENTES			
	  </div>';

echo '<table border="0"  cellspacing="4" width=95% align="left">';

$cQry = " SELECT *
          FROM cliente ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );
$i   = 0;

if ( $num > 0 ) 
{
	while ( $ar = mysql_fetch_assoc( $rsc ) )
	{
		echo '  <tr>';
		echo '      <td><p>'.stripcslashes($ar['CLI_DESCRICAO']).'</p></td>';
		echo '  </tr>';
		$i++;
	}	
}

echo '</table>'; 

?>

