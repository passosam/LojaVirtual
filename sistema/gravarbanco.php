<?php
// criando a conexão com o banco de dados

include ( 'conexao.php' );

$url = $_GET ['url'];

if ( isset ( $_GET ['do'] ) )
{
    $do = $_GET [ 'do' ];
	if ( isset( $_GET['id'] ) )
    {
        $id = $_GET['id'];
    }
    else
    {
        $id = "";
    }
}    

else
{
    $do= "";
} 

if ( $url == "cliente" ) 
    
{
     if ( $do != "del" )
    {
        $cNome     = $_POST ['CLI_NOME'];
        $cEndereco = $_POST ['CLI_ENDERECO'];
        $cCidade   = $_POST ['CLI_CIDADE'];
        $cUf       = $_POST ['CLI_UF'];
        $cTelefone  = $_POST ['CLI_TELEFONE'];
        $cObs      = $_POST ['CLI_OBS'];
		$cStatus   = $_POST ['CLI_STATUS'];
      
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
        
        $cQry = " SELECT MAX( CLI_CODIGO )AS CODIGO
                FROM apl_cliente";

        $rsc  = mysql_query ( $cQry, $conexao );

        $ar   = mysql_fetch_assoc($rsc);

        $cCodigo   = $ar ['CODIGO']+1;


        $cInsere = 'INSERT INTO apl_cliente ( CLI_CODIGO,CLI_NOME,CLI_ENDERECO,CLI_CIDADE,CLI_UF,
                                            CLI_TELEFONE, CLI_OBS, CLI_STATUS)

                    VALUES(    '.$cCodigo.',
                            "'.$cNome.'",
                            "'.$cEndereco.'",
                            "'.$cCidade.'",
                            "'.$cUf.'",
                            "'.$cTelefone.'",
                            "'.$cObs.'" ,
							"'.$cStatus.'")';
							
        $cResult = mysql_query ( $cInsere, $conexao );
		
    }
    elseif ( $do == "edit" )
    {

        $cQuery = ' UPDATE apl_cliente
                    SET CLI_NOME     = "'.$cNome.'",
                        CLI_ENDERECO = "'.$cEndereco.'",
                        CLI_CIDADE   = "'.$cCidade.'",
                        CLI_UF       = "'.$cUf.'",
                        CLI_TELEFONE = "'.$cTelefone.'",
                        CLI_OBS      = "'.$cObs.'",
						CLI_STATUS   = "'.$cStatus.'"
                    WHERE CLI_CODIGO = '.$id.'';
        
        $cResult = mysql_query ( $cQuery, $conexao );
	
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM apl_cliente
                     WHERE CLI_CODIGO = $id ";
        $cResult = mysql_query ( $cQuery, $conexao );
    }
	if ( $cResult )
    {

		echo '<script type="text/javascript"> alert("Cadastro efetuado com sucesso!" ); 
               location.href="index.php?url=cliente";</script>';
    }
    else
    {
 
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=cliente";</script>';
    }
   
}   
elseif ( $url == "os" )   
{
	if ( $do == "new" || $do == "alt"  )
	{
		$cCliente = $_POST ['CLI_CODIGO'];
		$cEquipamento  = $_POST ['EQP_CODIGO'];
		$cServico  = $_POST ['TPS_CODIGO'];
		$cData     = DtoS($_POST ['ORS_DTINICIO']);
		$cHora     = $_POST ['ORS_HORAINICIO'];
		$cNumero   = $_POST ['ORS_NUMERO'];
		$cUsuario   = $_POST ['USU_CODIGO'];
       
		if ( $do == "new" )
		{
			$cQry = " SELECT MAX( ORS_CODIGO )AS CODIGO
					  FROM apl_ordemservico";

			$rsc  = mysql_query ( $cQry, $conexao );

			$ar   = mysql_fetch_assoc($rsc);

			$cCodigo   = $ar ['CODIGO']+1;			
			$cDefeito  = $_POST ['ORS_DESCDEFEITO'];


			$cInsere = 'INSERT INTO apl_ordemservico ( ORS_CODIGO,ORS_NUMERO,CLI_CODIGO,USU_CODIGO,TPS_CODIGO,
													   ORS_HORAINICIO, ORS_DTINICIO, ORS_DESCDEFEITO, EQP_CODIGO)

						VALUES( '.$cCodigo.',
								"'.$cNumero.'",
								'.$cCliente.',
								'.$cUsuario.',
								'.$cServico.',
								"'.$cHora.'",
								"'.$cData.'",
								"'.$cDefeito.'",
								'.$cEquipamento.')';;
								
								//echo $cInsere;
			$cResult = mysql_query ( $cInsere, $conexao );
			//exit;
		}	
		elseif ($do == "alt")
		{
			$cQryCod = "SELECT ORS_CODIGO FROM apl_ordemservico WHERE ORS_NUMERO = ".$cNumero;
			$rscCod  = mysql_query ( $cQryCod, $conexao );
			$arCod   = mysql_fetch_assoc($rscCod);
			
			$cNumero = $arCod['ORS_CODIGO'];
			
            if (isset($_POST['del']))
			{
				$cCodigo = $_POST['COM_CODIGO'];
				
				$cQuery = "  DELETE 
							 FROM apl_complemento
							 WHERE ORS_CODIGO = '".$cNumero."' AND COM_CODIGO = '".$cCodigo."' ";
							 
				$cResult = mysql_query ( $cQuery, $conexao );
				
				echo '<script type="text/javascript">location.href="index.php?url=os&do=alt&id1='.$cNumero.'";</script>';	
		
			}
			elseif (isset($_POST['add']) || isset($_POST['salvar']))
			{
				if (isset($_POST['COM_HRFIM']) and ($_POST['COM_HRFIM'] <> '') )
				{
					$cDtInicio = DtoS($_POST['COM_DATA']);
					$cHrini    = $_POST['COM_HRINICIO'];
					$cHrfim    = $_POST['COM_HRFIM'];								
					
					$cQry = " SELECT MAX( COM_CODIGO )AS CODIGO
							  FROM apl_complemento";

					$rsc  = mysql_query ( $cQry, $conexao );

					$ar   = mysql_fetch_assoc($rsc);

					$cCodigo   = $ar ['CODIGO']+1;						
					
									
					$cInsere = 'INSERT INTO apl_complemento (ORS_CODIGO,COM_CODIGO,COM_DATA,COM_HRINI, COM_HRFIM)
								VALUES( '.$cNumero.',
										'.$cCodigo.',
										"'.$cDtInicio.'",
										"'.$cHrini.'",
										"'.$cHrfim.'" )';
										
					$cResult = mysql_query ( $cInsere, $conexao );
				}	
				if (isset($_POST['add']))
				{
					echo '<script type="text/javascript">location.href="index.php?url=os&do=alt&id1='.$cNumero.'&op=outro";</script>';
				}	
			}
			elseif (isset($_POST['not']))
			{
				echo '<script type="text/javascript">location.href="index.php?url=os&do=alt&id1='.$cNumero.'&op=outro";</script>';
			}
			elseif (isset($_POST['notdel']))
			{
				echo '<script type="text/javascript">location.href="index.php?url=os&do=alt&id1='.$cNumero.'";</script>';
			}

			
			$cServicoExec = $_POST['ORS_SERVEXECUTADO'];
			
			$cInsere = 'UPDATE apl_ordemservico 
						SET		
								CLI_CODIGO = '.$cCliente.',
								USU_CODIGO='.$cUsuario.',
								TPS_CODIGO='.$cServico.',
								ORS_HORAINICIO="'.$cHora.'",
								ORS_DTINICIO="'.$cData.'",
								ORS_SERVEXECUTADO = "'.$cServicoExec.'",
								EQP_CODIGO ='.$cEquipamento.'
						WHERE ORS_CODIGO = "'.$cNumero.'"	';	
						
			$cResult = mysql_query ( $cInsere, $conexao );
			$do = "acomp";
                        		
		}
    }
    elseif ( $do == "edit" )
    {

        $cQuery = ' UPDATE apl_cliente
                    SET CLI_NOME     = "'.$cNome.'",
                        CLI_ENDERECO = "'.$cEndereco.'",
                        CLI_CIDADE   = "'.$cCidade.'",
                        CLI_UF       = "'.$cUf.'",
                        CLI_TELEFONE = "'.$cTelefone.'",
                        CLI_OBS      = "'.$cObs.'"
                    WHERE CLI_CODIGO = '.$id.'';
        
        $cResult = mysql_query ( $cQuery, $conexao );
	
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM apl_ordemservico
                     WHERE ORS_CODIGO = $id ";
        $cResult = mysql_query ( $cQuery, $conexao );
		
		$cQuery = "  DELETE 
                     FROM apl_complemento
                     WHERE ORS_CODIGO = $id ";
        $cResult = mysql_query ( $cQuery, $conexao );
		
		$cQuery = "  DELETE 
                     FROM apl_despesas
                     WHERE ORS_CODIGO = $id ";
        $cResult = mysql_query ( $cQuery, $conexao );
		
		$cQuery = "  DELETE 
                     FROM apl_ospecas
                     WHERE ORS_CODIGO = $id ";
        $cResult = mysql_query ( $cQuery, $conexao );
		
		$do = "acomp";
    }
	elseif ( $do == "inc" )
	{
	    $cTipo = $_POST['COM_TIPO'];
		$cDtInicio = DtoS($_POST['COM_DATA']);
		$cOs = $_POST['ORS_CODIGO'];
		$cTpHora     = $_POST['COM_TPHORA'];
		$cHrini  = $_POST['COM_HRINICIO'];
		$cHrfim   = $_POST['COM_HRFIM'];
		$cDefeito = $_POST['ORS_DESCDEFEITO'];
		$cDescricao = $_POST['COM_DESCRICAO'];
		
		if (isset($_POST['COM_KM']))
		{
			$cKm  = $_POST['COM_KM'];
        }
		else
		{
			$cKm  = "";
		}
        $cQry = " SELECT MAX( COM_CODIGO )AS CODIGO
                  FROM apl_complemento";

        $rsc  = mysql_query ( $cQry, $conexao );

        $ar   = mysql_fetch_assoc($rsc);

        $cCodigo   = $ar ['CODIGO']+1;	
		
		$do = "acomp";
		
		$cInsere = 'INSERT INTO apl_complemento ( ORS_CODIGO,COM_TIPO,COM_CODIGO,COM_DATA,COM_TPHORA,
                                                  COM_HRINI, COM_HRFIM, COM_DESCRICAO, COM_KM)

                    VALUES( '.$cOs.',
                            "'.$cTipo.'",
                            '.$cCodigo.',
                            "'.$cDtInicio.'",
                            "'.$cTpHora.'",
                            "'.$cHrini.'",
                            "'.$cHrfim.'",
							"'.$cDescricao.'",
							"'.$cKm.'" )';
							
        $cResult = mysql_query ( $cInsere, $conexao );
		
		$cUpdate = 'UPDATE apl_ordemservico SET ORS_DESCDEFEITO = "'.$cDefeito.'" WHERE ORS_CODIGO = '.$cOs.'';
		$cResult = mysql_query ( $cUpdate, $conexao );
	}
	elseif ( $do == "dep" )
	{
	    $cOs       = $_POST['ORS_CODIGO'];
		$cValor    = str_replace( ",", '',$_POST['DEP_VALOR']);
		$cDespesa  = $_POST['DEP_CODIGO'];
        
        $cQry = " SELECT MAX( DES_CODIGO )AS CODIGO
                  FROM apl_despesas";

        $rsc  = mysql_query ( $cQry, $conexao );

        $ar   = mysql_fetch_assoc($rsc);

        $cCodigo   = $ar ['CODIGO']+1;	
		
		$do = "acomp";
		
		$cInsere = 'INSERT INTO apl_despesas(ORS_CODIGO, DES_CODIGO, DES_VALOR, TIP_CODIGO)
                    VALUES( '.$cOs.', 
							'.$cCodigo.',
					        "'.$cValor.'",
                            "'.$cDespesa.'")';
	
        $cResult = mysql_query ( $cInsere, $conexao );
		
		$do = "acomp";
	}
	elseif ( $do == "pec" )
	{
	    $cOs    = $_POST['ORS_CODIGO'];
		$cPeca  = $_POST['PEC_CODIGO'];
        
        $cQry = " SELECT MAX( OSP_CODIGO )AS CODIGO
                  FROM apl_ospecas";

        $rsc  = mysql_query ( $cQry, $conexao );

        $ar   = mysql_fetch_assoc($rsc);

        $cCodigo   = $ar ['CODIGO']+1;	
		
		$do = "acomp";
		
		$cInsere = 'INSERT INTO apl_ospecas(OSP_CODIGO,ORS_CODIGO, PEC_CODIGO)
                    VALUES( '.$cCodigo.',
							'.$cOs.', 
							'.$cPeca.')';
	
        $cResult = mysql_query ( $cInsere, $conexao );
		
		$do = "acomp";
	}
	elseif ( $do == "fec" )
	{
            $do = "fec";
            
            $cOs    = $_GET['id'];
            $cQry = " SELECT count(*) as total
                      FROM apl_complemento
                      WHERE ORS_CODIGO = '".$cOs."' ";

            $rsc  = mysql_query ( $cQry, $conexao );

            $ar   = mysql_fetch_assoc($rsc);
            
            if ( $ar['total'] > 0 )
            {
    
                $cInsere = 'UPDATE apl_ordemservico
                            SET ORS_STATUS = "F"
                            WHERE ORS_CODIGO = '.$cOs.'';

                $cResult = mysql_query ( $cInsere, $conexao );
            }
            else
            {
                echo '<script type="text/javascript"> alert("Favor informar as horas trabalhadas antesf de realizar o fechamento!" ); 
                       location.href="index.php?url=os&do='.$do.'";</script>';
            }    
	}
	if ( $cResult )
    {
		if ( $do == "new" || $do == "fec" )
		{						
			require("../phpmailer/class.phpmailer.php");
		
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth   = true;				
			$mail->Host	      = "smtp.mevatech.com.br";	 
			$mail->Port	      = 587;	
			$mail->Username = "envia@mevatech.com.br";    //--SMTP username
			$mail->Password = "Oregon147";                //--SMTP password
			$mail->From     = "mevatech.contatos@mevatech.com.br";
                       
			if ( $do == "new" )
			{
				$cQry = "SELECT CLI_NOME FROM apl_cliente WHERE CLI_CODIGO = ".$cCliente;
				$rsc  = mysql_query ( $cQry, $conexao );
				$ar   = mysql_fetch_assoc($rsc);
				
				$cCliente1 = $ar['CLI_NOME'];
				
				$cQry1 = "SELECT USU_NOME FROM apl_usuario WHERE USU_CODIGO = ".$cUsuario;
				$rsc1  = mysql_query ( $cQry1, $conexao );
				$ar1   = mysql_fetch_assoc($rsc1);
				
				$cUsuario1 = $ar1['USU_NOME'];
				$mail->FromName = "Workflow Abertura de O.S.";
			}
			else if ( $do == "fec" )
			{
				$cQry = "SELECT * FROM apl_ordemservico WHERE ORS_CODIGO = ".$cOs ;
				$rsc  = mysql_query ( $cQry, $conexao );
				$arFec = mysql_fetch_assoc($rsc);
							
				$mail->FromName = "Workflow Fechamento de O.S.";				
			}
                        else if ( $do == "alt" )
                        {
                                $cQryOS = "SELECT * FROM apl_ordemservico WHERE ORS_CODIGO = ".$cOs ;
				$rscOS  = mysql_query ( $cQryOS, $conexao );
				$arOS = mysql_fetch_assoc($rscOS);
                                
                                $cQryAlt = "SELECT * FROM apl_complemento WHERE ORS_CODIGO = ".$cOs ;
				$rscAlt  = mysql_query ( $cQryAlt, $conexao );
                                
                                $DadHoras = "";
                                
				while ($arAlt = mysql_fetch_assoc($rscAlt))
                                {
                                    $DadHoras = $DadHoras + "<b>Data Atendimento:</b> " + StoD($arAlt['COM_DATA']) + " <b>Hora Inicial:</b> " +
                                                $arAlt['COM_HRINI'] + " <b>Hora Final:</b> " +$arAlt['COM_HRFIM'] + "</br>";
                                }
							
				$mail->FromName = "Workflow Alteração de O.S.";
                        }
			$mail->AddAddress("mevatech.contatos@mevatech.com.br");
			$mail->Subject  = "Workflow Site";
			$mail->IsHTML(true);
			if ( $do == "fec" )
			{
				$mail->Body     = "<b>Chamado:</b> ".$arFec['ORS_NUMERO']." <br/><b>Data/Hora Fechamento:</b> ".date("d").'/'.date("m").'/'.date("Y")."/".date('H').':'.date('i')." <br/><br/>
						   <font size=1 color=blue><b>Mensagem enviada pelo site mevatech.com.br.</b>  ";
			}
			else if ( $do == "new" )
			{
				$mail->Body     = "<b>Chamado:</b> ".$cNumero." <br/><b>Data/Hora  Abertura:</b> ".$cData."/".$cHora." <br/><b>Cliente:</b> ".$cCliente1." <br/><b>Usu&aacute;rio:</b> ".$cUsuario1." <br/><b>Defeito:</b> ".$cDefeito." <br/><br/>
						   <font size=1 color=blue><b>Mensagem enviada pelo site mevatech.com.br.</b>  ";
			}	
                        else if ( $do == "alt" )
                        {
                            $mail->Body     = "<b>Chamado:</b> ".$cNumero." <br/><b>Data/Hora  Abertura:</b> ".$cData."/".$cHora." <br/><b>Cliente:</b> ".$cCliente1." <br/><b>Usu&aacute;rio:</b> ".$cUsuario1." <br/><b>Defeito:</b> ".$cDefeito." <br/><b>Serviço Executado:</b> ".$arOS['ORS_SERVEXECUTADO']."</br>".$DadHoras." <br/><br/>
						   <font size=1 color=blue><b>Mensagem enviada pelo site mevatech.com.br.</b>  ";
                        }
			if(!$mail->Send()){
			  echo "A mensagem não pode ser enviada. <p>";
			  echo "Mailer Error: " . $mail->ErrorInfo;
			  exit;
			}
			
		}
		
		echo '<script type="text/javascript"> alert("Cadastro efetuado com sucesso!" ); 
               location.href="index.php?url=os&do='.$do.'";</script>';
    }
    else
    { 
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=os&do='.$do.'";</script>';
    }
}   

if ( $url == "equipamento" ) 
    
{
     if ( $do != "del" )
    {
        $cNome       = $_POST ['EQP_NOME'];
        $cModelo     = $_POST ['EQP_MODELO'];
        $cSerie      = $_POST ['EQP_SERIE'];
        $cCodigoeqp  = $_POST ['EQP_CODIGOEQP'];
        $cCliente    = $_POST ['CLI_CODIGO'];
        $cStatus     = $_POST ['EQP_STATUS'];
             
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
        
        $cQry = " SELECT MAX( EQP_CODIGO )AS CODIGO
                FROM apl_equipamento";

        $rsc  = mysql_query ( $cQry, $conexao );

        $ar   = mysql_fetch_assoc($rsc);

        $cCodigo   = $ar ['CODIGO']+1;


        $cInsere = 'INSERT INTO apl_equipamento ( EQP_CODIGO,EQP_NOME,EQP_MODELO,EQP_SERIE,
                                                  EQP_CODIGOEQP, CLI_CODIGO, EQP_STATUS)

                    VALUES(  '.$cCodigo.',
                            "'.$cNome.'",
                            "'.$cModelo.'",
                            "'.$cSerie.'",
                            "'.$cCodigoeqp.'",
                            "'.$cCliente.'",
                            "'.$cStatus.'"	)';
        
        $cResult = mysql_query ( $cInsere, $conexao );
	
    }
    elseif ( $do == "edit" )
    {

        $cQuery = ' UPDATE apl_equipamento
                    SET EQP_NOME      = "'.$cNome.'",
                        EQP_MODELO    = "'.$cModelo.'",
                        EQP_SERIE     = "'.$cSerie.'",
                        EQP_CODIGOEQP = "'.$cCodigoeqp.'",
                        CLI_CODIGO    = "'.$cCliente.'",
						EQP_STATUS    = "'.$cStatus.'"
                    WHERE EQP_CODIGO  = '.$id.'';
        
        $cResult = mysql_query ( $cQuery, $conexao );
	
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM apl_equipamento
                     WHERE EQP_CODIGO = $id ";
        $cResult = mysql_query ( $cQuery, $conexao );
    }
	if ( $cResult )
    {

		echo '<script type="text/javascript"> alert("Cadastro efetuado com sucesso!" ); 
               location.href="index.php?url=equipamento";</script>';
    }
    else
    {
 
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=equipamento";</script>';
    }
   
}    

elseif ( $url == "usuario" )
{
    if ( $do != "del" )
    {
        $cNome    = $_POST['USU_NOME'];
        $cLogin   = $_POST['USU_LOGIN'];
        $cPerfil  = $_POST['USU_PERFIL'];
        $cEmail  = $_POST['USU_EMAIL'];
      
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
        $cSenha = md5( $_POST['USU_SENHA'] );
        
        $cQry = " SELECT MAX( CODIGOUSUARIO ) AS CODIGO
                  FROM lj_usuario ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO lj_usuario ( CODIGOUSUARIO, NOME, LOGIN, EMAIL, SENHA, CODIGOPERFIL )
                    VALUES ( "'.$cCodigo.'",
                              "'.$cNome.'" ,
                              "'.$cLogin.'" ,
							  "'.$cEmail.'",
                              "'.$cSenha.'" ,
                              "'.$cPerfil.'" )';
        
    }
    elseif ( $do == "edit" )
    {
        $cSenha = md5( $_POST['USU_SENHA'] );

        $cQuery = ' UPDATE lj_usuario
                    SET NOME     = "'.$cNome.'",
                        LOGIN    = "'.$cLogin.'",
                        SENHA    = "'.$cSenha.'",
                        CODIGOPERFIL   = "'.$cPerfil.'",
						EMAIL    = "'.$cEmail.'"
                    WHERE CODIGOUSUARIO = '.$id.'';
        
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM lj_usuario
                     WHERE CODIGOUSUARIO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
		
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=usuario";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=usuario";</script>';
    }
}

elseif ( $url == "empresa" )
{
    if ( $do != "del" )
    {
        $cDescricao = addslashes( $_POST['EMP_DESCRICAO'] );	
	}  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( EMP_CODIGO ) AS CODIGO
                  FROM empresa ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO empresa ( EMP_CODIGO, EMP_DESCRICAO )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cDescricao .'" )';						 
							 
    }
    elseif ( $do == "edit" )
    {
        $cQuery = ' UPDATE empresa
                    SET   EMP_DESCRICAO = "'.$cDescricao.'"
                    WHERE EMP_CODIGO = '.$id.'';
        
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM empresa
                     WHERE EMP_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );

    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=empresa";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=empresa";</script>';
    }
}
elseif ( $url == "imagem" )
{
	
    if ( $do != "del" )
    {
		$cPagina   = $_POST['IMG_PAGINA'];
		$cImagem   = $_FILES['IMG_IMAGEM']['name'];		
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( IMG_CODIGO ) AS CODIGO
                  FROM imagens ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO imagens ( IMG_CODIGO, IMG_PAGINA, IMG_IMAGEM )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cPagina.'" ,
                             "'.$cImagem.'" )';
    }

    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM imagens
                     WHERE IMG_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        if ( $do == "new" )
        {
            //PROPRIEDADES DO UPLOAD DO ARQUIVO
            $name   = $_FILES['IMG_IMAGEM']['name'];
            $type   = $_FILES['IMG_IMAGEM']['type'];
            $size   = $_FILES['IMG_IMAGEM']['size'];
            $temp   = $_FILES['IMG_IMAGEM']['tmp_name'];
            $error  = $_FILES['IMG_IMAGEM']['error'];

            if ( $error > 0 )
            {
                die("Ouve alguns problemas. ! Codigo do<b></b> Erro: $error.");
            }
            else
            {
                if($type == "video/avi" || $size > 2000000) //imagens que pode ser upload, e tamanho de arquivo maximo
                {
                    die("Arquivo não aceito ou tamanho acima do Limite.");
                }
                else
                {
                    move_uploaded_file($temp,"../image/pagina/".$name);
                }
            }
        }
        
        
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=imagem";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=imagem";</script>';
    }
    
}
elseif ( $url == "pecas" )
{
    if ( $do != "del" )
    {
        
        $cDescricao  = addslashes( $_POST['PEC_DESCRICAO'] );
        $cPcodigo    = ($_POST['PEC_CODIGOPEC']);
        
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( PEC_CODIGO ) AS CODIGO
                  FROM apl_pecas ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO apl_pecas ( PEC_CODIGO, PEC_DESCRICAO, PEC_CODIGOPEC )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cDescricao.'",
                             "'.$cPcodigo.'")';
    }
    elseif ( $do == "edit" )
    {
        $cQuery = ' UPDATE apl_pecas
                    SET   PEC_DESCRICAO = "'.$cDescricao.'",
                          PEC_CODIGOPEC = "'.$cPcodigo.'"
                    WHERE PEC_CODIGO  = '.$id.'';
   
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM  apl_pecas
                     WHERE PEC_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=pecas";</script>';
    }
   else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=pecas";</script>';
    }
}

elseif ( $url == "tiposervico" )
{
    if ( $do != "del" )
    {
        
        $cDescricao  = addslashes( $_POST['TPS_DESCRICAO'] );
        $cTpservico  = ($_POST['TPS_CODIGOTIPOSER']);
        
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( TPS_CODIGO ) AS CODIGO
                  FROM apl_tpservico ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO apl_tpservico ( TPS_CODIGO, TPS_DESCRICAO, TPS_CODIGOTIPOSER )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cDescricao.'",
                             "'.$cTpservico.'")';
    }
    elseif ( $do == "edit" )
    {
        $cQuery = ' UPDATE apl_tpservico
                        SET TPS_CODIGOTIPOSER = "'.$cDescricao.'",
                        TPS_DESCRICAO         = "'.$cTpservico.'"
                    WHERE TPS_CODIGO          = '.$id.'';
   
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM  apl_tpservico
                     WHERE TPS_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=tiposervico";</script>';
    }
   else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=tiposervico";</script>';
    }
}

elseif ( $url == "tipodespesa" )
{
    if ( $do != "del" )
    {
        
        $cDescricao  = addslashes( $_POST['TIP_DESCRICAO'] );
        
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( TIP_CODIGO ) AS CODIGO
                  FROM apl_tipodespesa ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO apl_tipodespesa ( TIP_CODIGO, TIP_DESCRICAO )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cDescricao.'" )';
    }
    elseif ( $do == "edit" )
    {
        $cQuery = ' UPDATE apl_tipodespesa
                    SET   TIP_DESCRICAO       = "'.$cDescricao.'"
                    WHERE TIP_CODIGO          = '.$id.'';
   
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM  apl_tipodespesa
                     WHERE TIP_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=tipodespesa";</script>';
    }
   else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=tipodespesa";</script>';
    }
}

elseif ( $url == "troca" )
{	
	if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
	
    $cSenha = md5( $_POST['USU_SENHA'] );
 
	$cQuery = ' UPDATE lj_usuario
                SET    SENHA    = "'.$cSenha.'"
                WHERE  CODIGOUSUARIO = '.$id.'';
        
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=troca";</script>';
    }
}

function DtoS( $cData )
{
    $cRet = substr( $cData, 6, 10 )."-".substr( $cData, 3, 2 )."-".substr( $cData, 0, 2 );
    
    return $cRet;
}

?>