<?php

include('conexao.php');

echo '<div id="cab13">
		<img src="image/servico/servico.png" border="0">
	  </div>';

echo '<div id="cab14">SERVI&Ccedil;OS			
	  </div>';

echo '<table border="0"  cellspacing="2" width=100% align="left">';

$cQry = " SELECT *
          FROM servico ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );
$i   = 0;

if ( $num > 0 ) 
{
	while ( $ar = mysql_fetch_assoc( $rsc ) )
	{
		echo '  <tr>';
		echo '      <td ><p>'.stripcslashes($ar['SER_DESCRICAO']).'</p></td>';
		echo '  </tr>';
		$i++;
	}	
}
 
?>
<tr><td align=center>
	<ul id="myGallery">
		<li><img src="image/banner/06092011360.jpg"/>
		<li><img src="image/banner/06092011359.jpg" />
		<li><img src="image/banner/06092011361.jpg"/>
		<li><img src="image/banner/06092011363.jpg" />
		<li><img src="image/banner/06092011362.jpg" />
		<li><img src="image/banner/06092011364.jpg" />
		<li><img src="image/banner/06092011365.jpg" />
		<li><img src="image/banner/07092011371.jpg" />
		<li><img src="image/banner/07092011373.jpg" />
		<li><img src="image/banner/07092011374.jpg" />		
		<li><img src="image/banner/26112009003.jpg" />
		<li><img src="image/banner/DSC04779.jpg" />
		<li><img src="image/banner/DSC05059.jpg" />
	</ul></td></tr>
	
	
</table>

