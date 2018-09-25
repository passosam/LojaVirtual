<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="title" content="MEVATECH - Tecnologia Clínica Especializada" />
<meta name="url" content="www.mevatech.com.br" />
<meta name="charset" content="utf-8" />
<meta name="description" content="MEVATECH - Tecnologia Clínica Especializada" />
<meta name="keywords" content="Tecnologia, clínica, especializada, câncer, tratamento, engenharia, serviço, serviços, radioterapia, montagem, empresa, projetos, nacional,
    qualidade, controle de barreira, barreira, ajustes, reparos, aceleradores, acelerador, lineares, linear, partículas, corretiva, manutenção, preventiva, mevatech, Mevatech, MEVATECH"/>
<meta name="autor" content="MEVATECH - Tecnologia Clínica Especializada" />
<meta name="company" content="MEVATECH - Tecnologia Clínica Especializada" />
<meta name="revisit-after" content="5" />
<link rev="made" href="" />
<title>MEVATECH - Se&ccedil;&atilde;o Administrativa</title>
<link rel="shortcut icon" href="../image/favicon.png" type="image/x-icon" />
<link href="../css/style1.css" rel="stylesheet" type="text/css" media="screen and (max-width: 8000px)"/>

</head>

<body>
    <div id="geral">
		<div id="cab1">
             <a href="index.php"><img src="../image/home/logo.png" border="0"/></a>
        </div>
				
		<div id="cab2">
			<div id="cabAdm">Se&ccedil;&atilde;o Administrativa</div>				
        </div>
		
		<div id="cab4"></div>
        
		<div id="cab3">
		
		<?php
			include ( '../conexao.php' );
	
			if ( isset( $_GET['url'] ) )
			{
				$url = $_GET['url'];
			}
			else
			{
				$url = "";
			} 

			if ( isset( $_GET['pagina'] ) )
			{
				$pagina = $_GET['pagina'];
			}
			else
			{
				$pagina = 1;
			} 
			 
            if ( !isset( $_SESSION['login_user'] ) ||  $url == "sair" )
            {
                $_SESSION['login_user'] = "";
            }

            if ( trim( $_SESSION['login_user'] ) == "logado" )
            { 
          ?>
				<div id="men1">
					<a href="index.php" class="menn">HOME</a></div>
				<div id="men6">|</div>	
				<div id="men2">
					<a href="index.php?url=empresa" class="menn">EMPRESA</a></div>
				<div id="men6">|</div>	
				<div id="men3">
					<a href="index.php?url=servico" class="menn">SERVI&Ccedil;OS</a></div>
				<div id="men6">|</div>	
				<div id="men4">
					<a href="index.php?url=cliente" class="menn">CLIENTES</a></div>
				<div id="men6">|</div>	
				<div id="men5">
					<a href="index.php?url=contato" class="menn">CONTATO</a></div>
				<div id="men6">|</div>	
				<div id="men5">
					<a href="index.php?url=usuario" class="menn">USU&Aacute;RIOS</a></div>
				<div id="men6">|</div>		
				<div id="men5">
					<a href="index.php?url=imagem" class="menn">IMAGENS</a></div>
				<div id="men6">|</div>
				<div id="men7">
					<a href="index.php?url=sair" class="menn">SAIR</a></div>
		</div>		
			
		<div id="corpo">
					
		<?php		
			
			if ( $url == '' )
			{
				echo '<b>'.$_SESSION['nome_user' ].', seja bem-vindo!</b> ';
			}
			elseif ( $url == 'contato' )
			{
				include('contato.php');
			}
			elseif ( $url == 'cliente' )
			{
				include('cliente.php');
			}
			elseif ( $url == 'empresa' )
			{
				include('empresa.php');
			}
			elseif ( $url == 'inicial' )
			{
				include('inicial.php');
			}
			elseif ( $url == 'servico' )
			{
				include('servico.php');
			}
			elseif ( $url == 'usuario' )
			{
				include('usuario.php');
			}
			elseif ( $url == 'imagem' )
			{
				include('imagem.php');
			}
			
			echo '</div>';
		}
		else
		{  
			echo '</div><div id="corpo">';
			
			if ( $url == "" || $url == "sair" )
			{
				echo '<div id="corpoAdLog">';
				
				echo '<form method="post" action="index.php?url=login" id="frmCad" name="frmCad">';

				echo '<table align=center border=0  width=250>';

				echo '  <tr>';
				echo '      <td><br><br><td>';
				echo '  </tr>';

				echo '  <tr>';
				echo '      <td colspan=2 class="CorContato">Fa&ccedil;a o login</td>';
				echo '  </tr>';

				echo '  <tr>';
				echo '      <td class="TitleCol">Login:</td>';
				echo '      <td><input type="text" name="login" id="login" title="Senha do us&uacute;ario" size="30" class="campo"></td>';
				echo '  </tr>';

				echo '  <tr>';
				echo '      <td class="TitleCol">Senha:</td>';
				echo '      <td><input type="password" name="senha" id="senha" title="Senha do us&uacute;ario" size="30" class="campo"></td>';
				echo '  </tr>';

				echo '  <tr>';
				echo '      <td colspan="2" align=center class="titulo2"><input type="submit" value="Enviar" name="botaoform" id="botaoform" class="submit"></td>';
				echo '  </tr>';

				echo '  <tr>';
				echo '      <td colspan="2"><font size=2 color=#666681>Ainda n&atilde;o tem a senha? Entre em contato com o administrador do sistema.</font></td>';
				echo '  </tr>';

				echo '  <tr>';
				echo '      <td><br><br></td>';
				echo '  </tr>';

				echo '</table>';

				echo '<br><br><br><br><br><br>';

				echo '</form>';
				
				echo '</div>';

			}
			elseif ( $url == "login")
			{
				$cLogin = $_POST['login'];
				$cSenha = md5( $_POST['senha'] );

				$cQry = " SELECT * 
						  FROM usuario
						  WHERE USU_NOME = '".trim( $cLogin )."' AND 
								USU_SENHA = '".trim( $cSenha )."' "; 

				$rsc = mysql_query( $cQry, $conexao );

				$num = mysql_num_rows( $rsc );

				if ( $num > 0 )
				{
					$ar  = mysql_fetch_assoc( $rsc );
					$_SESSION['nome_user' ] = $ar['USU_NOME'];
					$_SESSION['login_user'] = "logado";

					echo '<script type="text/javascript">location.href="index.php";</script>';
				}
				else
				{
					echo '<script type="text/javascript"> alert( "Login e/ou senha incorretos,\ntente novamente!" ); 
						location.href="index.php";</script>';

				}
			} 
			
			echo '</div>';
		}		
		?>
		
		<div id="footer">
			<div id="txtcont">&copy; Mevatech 2013 - Todos os direitos reservados.</div>           
		</div>
			
		</div>
			
	</div>	
    
</body>
</html>
    
