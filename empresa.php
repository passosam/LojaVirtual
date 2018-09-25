<?php

include('conexao.php');

echo '<div id="cab13">
		<img src="image/empresa/empresa.png" border="0">
	  </div>';

echo '<div id="cab14">A EMPRESA			
	  </div>';

echo '<table border="0"  cellspacing="0" width=95% align="left">';

$cQry = " SELECT *
          FROM empresa ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );
$i   = 0;

if ( $num > 0 ) 
{
	while ( $ar = mysql_fetch_assoc( $rsc ) )
	{
	
		echo '  <tr>';
		echo '      <td><p>'.stripcslashes($ar['EMP_DESCRICAO']).'</p></td>';
		echo '  </tr>';
		$i++;
	}	
}

echo '</table>'; 

?>

