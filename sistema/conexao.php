<?php
/*
usuário: paser100
senha: Oregon147

$dbname   = "mevatech"; 
$usuario  = "root"; 
$password = ""; 


*/


$hostname = "186.202.152.245";
$database = "portalgiaweb1";
$username = "portalgiaweb1";
$password = "advinfo_root";

/*
$hostname = "localhost";
$database = "mevatech";
$username = "root";
$password = "";
*/
if ( !( $conexao = mysql_connect( $hostname, $username, $password ) ) ) 
{
    echo "N&atilde;so foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
    exit;
} 

if ( !( $con = mysql_select_db( $database, $conexao ) ) ) 
{ 
    echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
    exit; 
} 


?>