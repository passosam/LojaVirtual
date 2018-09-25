<?php
// criando a conexão com o banco de dados

include ( '../conexao.php' );

$url = $_GET ['url'];

if ( isset ( $_GET ['do'] ) )
{
    $do = $_GET [ 'do' ];
}    

else
{
    $do= "";
}    

if ( $url == "contato" )
{
    $cQry = " SELECT MAX( CON_CODIGO )AS CODIGO
              FROM contato";
    
    $rsc  = mysql_query ( $cQry, $conexao );
    
    $ar   = mysql_fetch_assoc($rsc);
    
    $cCodigo   = $ar ['CODIGO']+1;
    $cNome     = $_POST ['COT_NOME'];
    $cEmail    = $_POST ['COT_EMAIL'];
    $cAssunto  = $_POST ['COT_ASSUNTO'];
    $cMensagem = $_POST ['COT_INFORMACAO'];
     
    $cInsere = 'INSERT INTO contato ( CON_CODIGO,CON_NOME,
                                      CON_EMAIL, CON_ASSUNTO, CON_MENSAGEM)
                                      
                VALUES(    '.$cCodigo.',
                           "'.$cNome.'",
                           "'.$cEmail.'",
                           "'.$cAssunto.'", 
                           "'.$cMensagem.'"    )';
    $cResult = mysql_query ( $cInsere, $conexao );
	
	if ( $cResult )
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
		$mail->FromName = "Envio Autom&aacute;tico";
		$mail->AddAddress("mevatech.contatos@mevatech.com.br");
		$mail->Subject  = "Contato Site";
		$mail->IsHTML(true);
		$mail->Body     = "<b>Nome:</b> ".$cNome." <br/><b>Email:</b> ".$cEmail." <br/><b>Assunto:</b> ".$cAssunto." <br/><b>Mensagem:</b> ".$cMensagem." <br/><br/>
                   <font size=1 color=blue><b>Mensagem enviada pelo site mevatech.com.br.</b>  ";
		if(!$mail->Send()){
		  echo "A mensagem não pode ser enviada. <p>";
		  echo "Mailer Error: " . $mail->ErrorInfo;
		  exit;
		}
			
		echo '<script type="text/javascript"> alert( unescape("Mensagem enviada com sucesso. Obrigado. Em breve nossa equipe far%E1 contato!") ); 
               location.href="../index.php";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=contato";</script>';
    }
   
}    
elseif ( $url == "usuario" )
{
    if ( $do != "del" )
    {
        $cNome  = $_POST['USU_NOME'];
      
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
        $cSenha = md5( $_POST['USU_SENHA'] );
        
        $cQry = " SELECT MAX( USU_CODIGO ) AS CODIGO
                  FROM usuario ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO usuario ( USU_CODIGO, USU_NOME, USU_SENHA )
                    VALUES ( "'.$cCodigo.'",
                              "'.$cNome.'" ,
                              "'.$cSenha.'" )';
        
    }
    elseif ( $do == "edit" )
    {
        $cSenha = md5( $_POST['USU_SENHA'] );

        $cQuery = ' UPDATE usuario
                    SET USU_NOME = "'.$cNome.'",
                        USU_SENHA = "'.$cSenha.'"
                    WHERE USU_CODIGO = '.$id.'';
        
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM usuario
                     WHERE USU_CODIGO = $id ";
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
elseif ( $url == "servico" )
{
    if ( $do != "del" )
    {
        
        $cDescricao  = addslashes( $_POST['SER_DESCRICAO'] );
        
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( SER_CODIGO ) AS CODIGO
                  FROM servico ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO servico ( SER_CODIGO, SER_DESCRICAO )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cDescricao.'")';
    }
    elseif ( $do == "edit" )
    {
        $cQuery = ' UPDATE servico
                    SET SER_DESCRICAO = "'.$cDescricao.'"
                    WHERE SER_CODIGO  = '.$id.'';
   
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM servico
                     WHERE SER_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=servico";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=servico";</script>';
    }
}
elseif ( $url == 'delcontato' ) 
{
	$id = $_GET['id'];
	
	$cQuery = "   DELETE 
                  FROM contato
                  WHERE CON_CODIGO = $id ";
    
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=contato";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=contato";</script>';
    }
	
}
elseif ( $url == "cliente" )
{
	if ( $do != "del" )
    {
        
        $cDescricao  = addslashes( $_POST['CLI_DESCRICAO'] );
        
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
               
        $cQry = " SELECT MAX( CLI_CODIGO ) AS CODIGO
                  FROM cliente ";

        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);

        $cCodigo = $ar['CODIGO']+1;

        $cQuery = ' INSERT INTO cliente ( CLI_CODIGO, CLI_DESCRICAO )
                    VALUES ( "'.$cCodigo.'",
                             "'.$cDescricao.'")';
    }
    elseif ( $do == "edit" )
    {
        $cQuery = ' UPDATE cliente
                    SET CLI_DESCRICAO = "'.$cDescricao.'"
                    WHERE CLI_CODIGO  = '.$id.'';
   
    }
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM cliente
                     WHERE CLI_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=cliente";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=cliente";</script>';
    }
/*
    if ( $do != "del" )
    {
        $cImagem  = $_FILES['CLI_IMAGEM']['name'];
        $cUrl     = $_POST['CLI_URL'];
      
    }  
    
    if ( $do != "new" )
    {
        $id = $_GET['id'];
    }
        
    if ( $do == "new" )
    {
        $cQry = " SELECT MAX( CLI_CODIGO ) AS CODIGO
                  FROM cliente ";
        
        $rsc = mysql_query( $cQry, $conexao );
        $nNum = mysql_num_rows( $rsc );
       
        if ( $nNum > 0 )
        {
            $ar = mysql_fetch_assoc($rsc);
            $cCodigo = $ar['CODIGO']+1;
        }
        else
        {
            $cCodigo = 1;
        }

        $cQuery = ' INSERT INTO cliente( CLI_CODIGO, CLI_IMAGEM, CLI_URL )
                    VALUES (  "'.$cCodigo.'",
                              "'.$cImagem.'" ,
                              "'.$cUrl.'" )';
        
    }
    
    elseif ( $do == "del" )
    {
        $cQuery = "  DELETE 
                     FROM cliente
                     WHERE CLI_CODIGO = $id ";
    }
    
    $cResult = mysql_query( $cQuery, $conexao );
    
    if ( $cResult )
    {
        if ( $do == "edit" || $do == "new" )
        {
            //PROPRIEDADES DO UPLOAD DO ARQUIVO
            $name  = $_FILES['CLI_IMAGEM']['name'];
            $type  = $_FILES['CLI_IMAGEM']['type'];
            $size  = $_FILES['CLI_IMAGEM']['size'];
            $temp  = $_FILES['CLI_IMAGEM']['tmp_name'];
            $error = $_FILES['CLI_IMAGEM']['error'];

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
                    move_uploaded_file($temp,"../image/cliente/fotos/".$name);
                }
            }
        }

        echo '<script type="text/javascript"> alert( "Processo realizado com sucesso!" ); 
               location.href="index.php?url=cliente";</script>';
    }
    else
    {
        echo '<script type="text/javascript"> alert( "Ocorreu um erro desconhecido, tente novamente mais tarde!" ); 
               location.href="index.php?url=cliente";</script>';
    }*/
}

function DtoS( $cData )
{
    $cRet = substr( $cData, 6, 10 )."-".substr( $cData, 3, 2 )."-".substr( $cData, 0, 2 );
    
    return $cRet;
}


?>