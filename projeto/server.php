<?php
require_once('lib\nusoap.php');

$server = new soap_server;

/*
$server->configureWSDL('server.dadosfornecedor','urn:server.dadosfornecedor');
$server->wsdl->schemaTargetNamespace = 'urn:server.dadosfornecedor';*/

$server->configureWSDL('server', 'http://portalgiaweb.com.br/projeto/');

$server->wsdl->schemaTargetNamespace = 'http://soapinterop.org/xsd/';

$server->register('dadosfornecedor', //nome do método
                  array('RAZAOSOCIAL' => 'xsd:string',
				        'LOGRADOURO' => 'xsd:string',
						'BAIRRO' => 'xsd:string',
						'CEP' => 'xsd:string',
						'COMPLEMENTO' => 'xsd:string',
						'CNPJ' => 'xsd:string',
						'INSCRICAOESTADUAL' => 'xsd:string',
						'EMAIL' => 'xsd:string',
						'TELEFONE' => 'xsd:string',
						'CELULAR' => 'xsd:string',
						'CIDADE' => 'xsd:string',
						'LOGIN' => 'xsd:string',
						'SENHA' => 'xsd:string'), // parametro de entrada
				  array('return' => 'xsd:string'), //parametro de saída
				  'urn:server.dadosfornecedor', //namespace
				  'urn.server.dadosfornecedor#dadosfornecedor', //soapaction
				  'rpc', //style
				  'encoded', //use
				  'Retorna se o houve sucesso no processo' //documentação do serviço
				  );
				  
$server->register('dadosproduto',
				  array('QTDESTOQUE' => 'xsd:integer',
				        'DESCRICAO' => 'xsd:string',
						'DESCRICAOCOMPLEMENTAR' => 'xsd:string',
						'VALORCOMPRA' => 'xsd:string',
						'CNPJ' => 'xsd:string',
						'CODIGOEXTERNO' => 'xsd:string',
						'LOGIN' => 'xsd:string',
						'SENHA' => 'xsd:string'), // parametro de entrada
				  array('return' => 'xsd:string'), //parametro de saída
				  'urn:server.dadosproduto', //namespace
				  'urn.server.dadosproduto#dadosproduto', //soapaction
				  'rpc', //style
				  'encoded', //use
				  'Retorna se o houve sucesso no processo' //documentação do serviço
				  );
				  
$server->register('atualizaestoque',
				  array('QTDESTOQUE' => 'xsd:integer',
				        'CNPJ' => 'xsd:string',
						'CODIGOEXTERNO' => 'xsd:string',
						'LOGIN' => 'xsd:string',
						'SENHA' => 'xsd:string'), // parametro de entrada
				  array('return' => 'xsd:string'), //parametro de saída
				  'urn:server.dadosproduto', //namespace
				  'urn.server.dadosproduto#dadosproduto', //soapaction
				  'rpc', //style
				  'encoded', //use
				  'Retorna se o houve sucesso no processo' //documentação do serviço
				  );
				  
$server->register('atualizapedido',
				  array('CNPJ' => 'xsd:string',
						'CODIGOEXTERNO' => 'xsd:string',
						'NUMEROPEDIDO' => 'xsd:integer',
						'STATUS' => 'xsd:string',
						'NUMRASTREIO' => 'xsd:string',
						'OBSERVACAO' => 'xsd:string'), // parametro de entrada
				  array('return' => 'xsd:string'), //parametro de saída
				  'urn:server.atualizapedido', //namespace
				  'urn.server.atualizapedido#atualizapedido', //soapaction
				  'rpc', //style
				  'encoded', //use
				  'Retorna se o houve sucesso no processo' //documentação do serviço
				  );				  
 					  
 	
	
function dadosfornecedor($cRazaosocial, $cLogradouro, $cBairro, $cCep, $cComplemento, $cCNPJ,
						 $cIE, $cEmail, $cTelefone, $cCelular, $cCidade, $cLogin, $cSenha ){
	
	require_once('db\conexao.php');
	
	if ($cLogin <> 'Task' or $cSenha <> 'TcxAut')
	{
		return 'ERRO  |1001 - Acesso negado!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';	
	}
	
	$cQry = " SELECT count(*) TOTAL
              FROM lj_fornecedor
			  WHERE CNPJ = '".$cCNPJ."' ";
    
    $rsc  = mysql_query ( $cQry, $conexao );				
				  
	$ar   = mysql_fetch_assoc($rsc);

	if ( $ar['TOTAL'] >= 1 ) 
	{
		return 'ERRO  |1003 - CNPJ j&aacute; cadastrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';		
	}
	else
	{		
		$cQry = 'INSERT INTO lj_fornecedor(RAZAOSOCIAL, LOGRADOURO, BAIRRO, CEP, COMPLEMENTO, CNPJ, 
		                                   INSCRICAOESTADUAL, EMAIL, TELEFONE, CELULAR, CIDADE, STATUS) 
				VALUES ("'.$cRazaosocial.'","'.$cLogradouro.'","'.$cBairro.'","'.$cCep.'","'.$cComplemento.'","'.$cCNPJ.'","'.$cIE.'",
				        "'.$cEmail.'","'.$cTelefone.'","'.$cCelular.'","'.$cCidade.'", "I" )';
		
		
		$Result  = mysql_query ( $cQry, $conexao );	
		
		if ($Result)
		{
			return 'OK  |Log: Fornecedor registrado com sucesso, aguardando  aprova&ccedil;&atilde;o!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';
		}
		else
		{
			return 'ERRO  |Log: Fornecedor n&atilde;o registrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|'.$cQry;		
		}
	}	
}

function dadosproduto($nQtdEstoque, $cDescricao, $cDescCompl, $nValorCompra, $cCNPJ, $cCodExterno, 
					  $cLogin, $cSenha){
	
	require_once('db\conexao.php');
	
	if ($cLogin <> 'Task' or $cSenha <> 'TcxAut')
	{
		return 'ERRO  |1001 - Acesso negado!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';	
	}
	
	
	$cQry = " SELECT CODIGOFORNECEDOR
              FROM lj_fornecedor
			  WHERE CNPJ = '".$cCNPJ."' ";
    
	
    $rsc  = mysql_query ( $cQry, $conexao );	

				  
	$ar   = mysql_fetch_assoc($rsc);

	
	if ( $ar['CODIGOFORNECEDOR'] < 1 ) 
	{
		return 'ERRO  |1003 - CNPJ n&atilde;o cadastrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';		
	}
	else
	{
		$nValorCompra =  str_replace(',','.',$nValorCompra);
		
		$cQry = 'INSERT INTO lj_produtos(QTDESTOQUE, DESCRICAO, DESCRICAOCOMPLEMENTAR, VALORCOMPRA, CODIGOFORNECEDOR,
		                                STATUS, DATACADASTRO, CODIGOEXTERNO) 
				VALUES ('.$nQtdEstoque.',"'.$cDescricao.'","'.$cDescCompl.'","'.$nValorCompra.'",'.$ar['CODIGOFORNECEDOR'].',"I","'.date('Y-d-m').'",
						"'.$cCodExterno.'")';
		
		
		$Result  = mysql_query ( $cQry, $conexao );	
		
		if ($Result)
		{
			return 'OK  |Log: Produto registrado com sucesso, aguardando aprova&ccedil;&atilde;o!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';
		}
		else
		{
			return 'ERRO  |Log: Produto n&atilde;o registrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|'.$cQry;		
		}
	}
}


function atualizapedido( $cCNPJ, $cCodExterno, $cNumPedido, $cStatus, $cNumRastreio, $cObservacao, $cLogin, $cSenha){
	
	require_once('db\conexao.php');
	
	if ($cLogin <> 'Task' or $cSenha <> 'TcxAut')
	{
		return 'ERRO  |1001 - Acesso negado!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';	
	}
		
	$cQry = " SELECT CODIGOFORNECEDOR
              FROM lj_fornecedor
			  WHERE CNPJ = '".$cCNPJ."' ";
    
	
    $rsc  = mysql_query ( $cQry, $conexao );					  
	$ar   = mysql_fetch_assoc($rsc);
	
	if ( $ar['CODIGOFORNECEDOR'] < 1 ) 
	{
		return 'ERRO  |1003 - CNPJ n&atilde;o cadastrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';		
	}
	
	$cQry1 = " SELECT lj_v.*
              FROM  lj_vendaitem lj_v 
				    inner join lj_produtos lj_p on
						       lj_v.CODIGOPRODUTO = lj_p.CODIGOPRODUTO
			  WHERE lj_p.CODIGOEXTERNO = '".$cCodExterno."' AND 
			        lj_p.CODIGOFORNECEDOR = '".$ar['CODIGOFORNECEDOR']."' AND
					lj_v.CODIGOVENDA = '".$cNumPedido."' ";
    
	
    $rsc1  = mysql_query ( $cQry1, $conexao );					  
	$ar1   = mysql_fetch_assoc($rsc1);
	
	if ($ar1['lj_v.CODIGOPRODUTO'] < 1)
	{
		return 'ERRO  |1004 - Pedido n&atilde;o localizado, verique os dados!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';	
	}	
	else
	{
		$cQry = "UPDATE lj_vendaitem 
		         SET STATUS = '".$cStatus."',
				     OBSERVACAO = '".$cObservacao."' ,
					 NUMRASTREIO = '".$cNumRastreio."',
					 DATASTATUS = '".date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s')."',
				 WHERE lj_v.CODIGOPRODUTO = '".$ar1['CODIGOPRODUTO']."' AND
					   lj_v.CODIGOVENDA = '".$cNumPedido."' "; 

		$Result  = mysql_query ( $cQry1, $conexao );	
		
		if ($Result)
		{
			return 'OK  |Log: Pedido atualizado com sucesso!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';
		}
		else
		{
			return 'ERRO  |Log: Pedido n&atilde;o atualizado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|'.$cQry;		
		}
	}
}

function atualizaestoque($nQtdEstoque, $cCNPJ, $cCodExterno, 
					     $cLogin, $cSenha){
	
	require_once('db\conexao.php');
	
	if ($cLogin <> 'Task' or $cSenha <> 'TcxAut')
	{
		return 'ERRO  |1001 - Acesso negado!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';	
	}
		
	$cQry = " SELECT CODIGOFORNECEDOR
              FROM lj_fornecedor
			  WHERE CNPJ = '".$cCNPJ."' ";
    
	
    $rsc  = mysql_query ( $cQry, $conexao );	

				  
	$ar   = mysql_fetch_assoc($rsc);

	if ( $ar['CODIGOFORNECEDOR'] < 1 ) 
	{
		return 'ERRO  |1003 - CNPJ n&atilde;o cadastrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';		
	}
	else
	{
		$cQry1 = " SELECT CODIGOPRODUTO
				   FROM lj_produtos
			       WHERE CODIGOEXTERNO = ".$cCodExterno." AND CODIGOFORNECEDOR = ".$ar['CODIGOFORNECEDOR']." ";
    
	
		$rsc1  = mysql_query ( $cQry1, $conexao );	
					  
		$ar1   = mysql_fetch_assoc($rsc1);
		
		if ( $ar1['CODIGOPRODUTO'] < 1 ) 
		{
			return 'ERRO  |1003 - Produto n&atilde;o cadastrado|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';		
		}
		else
		{
			$cQry2 = 'UPDATE lj_produtos 
			          SET QTDESTOQUE = QTDESTOQUE + '.$nQtdEstoque.'
					  WHERE CODIGOFORNECEDOR = '.$ar['CODIGOFORNECEDOR'].' AND 
							CODIGOPRODUTO = '.$ar1['CODIGOPRODUTO'];
			
			
			$Result  = mysql_query($cQry, $conexao);	
			
			if ($Result)
			{
				return 'OK  |Log: Produto atualizado com sucesso!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|';
			}
			else
			{
				return 'ERRO  |Log: Produto n&atilde;o atualizado!|Data|'.date('d').'/'.date('m').'/'.date('y').'|Hora|'.date('H').':'.date('i').':'.date('s').'|'.$cQry2;		
			}
		}
	}
}
//requisição para uso do serviço
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA)?$HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>