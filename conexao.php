<?php
/*
usuário: paser100
senha: Oregon147

$dbname   = "mevatech"; 
$usuario  = "root"; 
$password = ""; 

$dbname   = "lcalhost"; 
$usuario  = "site1380165237"; 
$password = "Oregon147"; 

*/


$hostname = "mysql01.site1380165237.hospedagemdesites.ws";
$database = "site1380165237";
$username = "site1380165237";
$password = "Oregon147";

//$conexao= mysql_connect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR);
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


/*
$dbname   = "mevatech"; 
$usuario  = "root"; 
$password = "";  

if ( !( $conexao = mysql_connect( "182.202.152.99", $usuario, $password ) ) ) 
{
    echo "N&atilde;so foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
    exit;
} 

if ( !( $con = mysql_select_db( $dbname, $conexao ) ) ) 
{ 
    echo "Não foi possível estabelecer uma conexão com o gerenciador MySQL. Favor Contactar o Administrador.";
    exit; 
} 
*/