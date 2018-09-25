<?php
/*
 * login katiamorucci
 * login banco - site1389642725
 * senha km22052205
 */
/*
 * 
$hostname = "localhost";
$database = "cartorio";
$username = "root";
$password = "";

 */
$hostname = "mysql01.site1389642725.hospedagemdesites.ws";
$database = "site1389642725";
$username = "site1389642725";
$password = "km22052205";




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