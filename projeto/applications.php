<?php
require_once('lib\nusoap.php');

$wsdl = 'http://www.portalgiaweb.com.br/projeto/server.php?wsdl';
$client = new soapclient($wsdl);
$err = $client->getError();

if ($err){
	echo "Erro no construtor".$err;
}

$result = $client->call('dadosfornecedor',array('Eletronicos & Cia','RUA SANTO ANTONIO, 1500, SALA 1012','CENTRO','36016210','',
												'123456789910','1234','	eletric@eletronicos.com.br','32187059','32984748072','JUIZ DE FORA', 
												'Task','TcxAut'));

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