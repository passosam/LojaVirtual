<?php
require_once('lib\nusoap.php');

$wsdl = 'http://www.portalgiaweb.com.br/projeto/server.php?wsdl';
$client = new soapclient($wsdl);
$err = $client->getError();

if ($err){
	echo "Erro no construtor".$err;
}
/*
$result = $client->call('dadosproduto',array(50,'Caixa Som Portatil Usb Fm Mp3 Rca Mic Sd Amplif Mega Bass',
											 'Caixa Som Portatil Usb Fm Mp3 Home Theather Auxilar Mic Sd Amplif Mega Bass Sem fio
											 Caixa De Som Sem Fio Home Theater 4x1 Fm P2 Bluetooth Usb Wm 1300 Celular Computador
											 CAIXA DE SOM BLUETOOTH HOME THEATER
											 Bluetooth - P2 - Micro SD - USB (P/ Pen Drive)','55.99',
											 '00881753000153','1050','Task','TcxAut'));
*/			

$result = $client->call('atualizaestoque',array(35, '00881753000153','1050','Task','TcxAut'));
								 
if ( $client->fault){
	echo "Falha".print_r($result);
}
else
{
	$err = $client->getError();
	if ($err){
		echo "Erro".$err;
	}
	else{
		echo($result);
	}
}
?>