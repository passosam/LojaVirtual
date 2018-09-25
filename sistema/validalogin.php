<?php

session_start();

include ('conexao.php');

$usuario = $_POST['USU_LOGIN'];
$senha = $_POST['USU_SENHA'];

$cQry = " SELECT p.*
          FROM lj_usuario p
          WHERE LOGIN = '".$usuario."' AND
                SENHA = '". md5($senha)."' ";
			
$rsc = mysql_query( $cQry, $conexao );

$ar = mysql_fetch_assoc( $rsc );

$num = mysql_num_rows( $rsc );

if ( $num > 0 )
{    
    $_SESSION['ss_nome'] = $ar['NOME'];
    $_SESSION['ss_codigo'] = $ar['CODIGOUSUARIO'];
    $_SESSION['ss_perfil'] = $ar['CODIGOPERFIL'];
     
	        
    echo '<script type="text/javascript">location.href="index.php?do=log";</script>'; 
	
}
else
{
    echo '<script type="text/javascript"> alert( "Login incorreto, tente novamente!" ); 
            location.href="../index.php";</script>';
}
	

?>
