<?php

include('conexao.php');

echo '<div id="cab13">
		<img src="image/cliente/cliente.png" border="0">
	  </div>';

echo '<div id="cab14">CLIENTES			
	  </div>';

echo '<div id="pagC"><table border="0"  cellspacing="4" width=105% align="left">';

$cQry = " SELECT *
          FROM cliente ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );

$i   = 0;
$j   = 8;
$x   = 1;

if ( $num > 0 ) 
{
	while ( $ar = mysql_fetch_assoc( $rsc ) )
	{
		if ( $x == 0 )
		{
			echo '  <tr>';
		}
			
		echo '<td><div id="imgpag1">';
		echo '	<div style="position:relative; top:0px; left:0px;">';
		echo '		<img src="image/cliente/box.png" border="0">';
		echo '			<div style="position:absolute; top:6px; left:6px;">';
		echo '				<a href="http://'.$ar['CLI_URL'].'" border=0 target="_blank"><img src="image/cliente/fotos/'.$ar['CLI_IMAGEM'].'" border="0"></a>';
		echo '			</div>';
		echo '	</div>';
		echo '</div></td>';
		
		
		if ( $x == 4 )
		{
			echo '  </tr>';
			echo '  <tr>';	
		}
		
		$j--;
	    $x++;
	}
}
else
{
	while ( $j >= 1 )
	{
		if ( $x == 0 )
		{
			echo '  <tr>';
		}
			
			echo '<td><div id="imgpag1">';
			echo '	<div style="position:relative; top:0px; left:0px;">';
			echo '		<img src="image/cliente/box.png" border="0">';
			echo '			<div style="position:absolute; top:6px; left:6px;">';
			echo '			</div>';
			echo '	</div>';
			echo '</div></td>';
		
		
		if ( $x == 4 )
		{
			echo '  </tr>';
			echo '  <tr>';	
		}
		
		$j--;
	    $x++;
	}	
}

echo '  </tr>';

echo '</table></div>'; 

?>

