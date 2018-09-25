<?php
    include ( 'conexao.php' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="title" content="@ELETRA - Loja Virtual" />
<meta name="url" content="www.@eletra.com.br" />
<meta name="charset" content="utf-8" />
<meta name="description" content="@ELETRA - Loja Virtual" />
<meta name="keywords" content="@ELETRA, ELETRA, Loja virtual, eletronicos, caixa de som, fone de ouvido, celular, outros"/>
<meta name="autor" content="@ELETRA - Loja Virtual" />
<meta name="company" content="@ELETRA - Loja Virtual" />
<meta name="revisit-after" content="5" />
<link rev="made" href="" />
<title>@ELETRA - Loja Virtual</title>
<link rel="shortcut icon" href="image/favicon.png" type="image/x-icon" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen and (max-width: 8000px)"/>

<!-- First, add jQuery (and jQuery UI if using custom easing or animation -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

<!-- Second, add the Timer and Easing plugins -->
<script type="text/javascript" src="js/jquery.timers-1.2.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>

<!-- Third, add the GalleryView Javascript and CSS files -->
<script type="text/javascript" src="js/jquery.galleryview-3.0-dev.js"></script>
<link type="text/css" rel="stylesheet" href="css/jquery.galleryview-3.0-dev.css" />

<!-- Lastly, call the galleryView() function on your unordered list(s) -->
<script type="text/javascript">
	$(function(){
		$('#myGallery').galleryView();
	});
</script>
</head>

<body>
	
    <div id="geral"><form name="frmLogin" action="sistema/validalogin.php" method="post">
		<div id="cab1">
             <a href="index.php"><img src="image/home/logo.png" border="0"/></a>
        </div>
				
		<div id="cab2">
            <div id="imagem"><img src="image/home/cadeado.png" border="0"></div>
			<div id="login">&Aacute;REA DO CLIENTE</div>
			<div id="tam1">
				<div id="field2"><input type="text" name="USU_LOGIN" onFocus="javascript:this.value=''" id="USU_LOGIN" size="27" value="Login"></div>
			</div>	
			
			<div id="tam2">	
				<div id="field2"><input type="password" name="USU_SENHA" onFocus="javascript:this.value=''" id="USU_SENHA" size="27" value="Senha"></div>
			</div>	
			
			<div id="tam3">
							<input type="image" src="image/home/botao.png" onClick="this.form.submit()">
							</form></div>
						
        </div>
		
		<div id="cab4"></div>
        
		<div id="cab3">
			<div id="men1">
				<a href="index.php" class="menn">HOME</a></div>
			<div id="men6">|</div>	
			<div id="men2">
				<a href="index.php?url=empresa" class="menn">A EMPRESA</a></div>
			<div id="men6">|</div>	
			<div id="men3">
				<a href="index.php?url=servico" class="menn">SERVI&Ccedil;OS</a></div>
			<div id="men6">|</div>	
			<div id="men4">
				<a href="index.php?url=clientes" class="menn">CLIENTES</a></div>
			<div id="men6">|</div>	
			<div id="men5">
				<a href="index.php?url=contato" class="menn">CONTATO</a></div>
			<div id="men7">	
				<div id="field">
					<input type="text" size="40" value="Busque no site" />
					<button type="button" id="virtual-keyboard"><img src="image/home/lupa.png" border="0"/></button>
				</div>
			</div>
		</div> 
		
		<div id="corpo">
			
			<?php
	 	
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
	 
			if ( $url == '' )
			{		 
		
			?>
			
				<div id="txthome">
					
					<div id="cab5">
						<img src="image/home/empresa.png" border="0">
					</div>
					
					<div id="cab6">A EMPRESA			
						<div id="cab7">A MEVATECH &eacute; uma empresa de servi&ccedil;os, que atua no segmento de radioterapia. Especializada em montagens...  <a href="index.php?url=empresa" class="menn2"> LEIA MAIS</a>
						</div>
					</div>
											
					<div id="cab8">
						<hr width="100%" align="left" color="#cccccc">
					</div>
								
					<div id="cab9">
						<img src="image/home/servico.png" border="0">
					</div>
					
					<div id="cab10">SERVI&Ccedil;OS			
						<div id="cab7">A MEVATECH oferece in&uacute;meros serviços na &aacute;rea de radioterapia como: Projetos de salas, C&aacute;lculos de barreira...<a href="index.php?url=servico" class="menn2"> LEIA MAIS</a>
						</div>
					</div>
					
					<div id="cab11">
						<hr width="100%" align="left" color="#cccccc">
					</div>
					
					<div id="cab9">
						<img src="image/home/cliente.png" border="0">
					</div>
					
					<div id="cab12">CLIENTES			
						<div id="cab7">A MEVATECH atua em todo o território nacional respeitando os seus clientes e mantendo total fidelidade a eles...<a href="index.php?url=clientes" class="menn2"> LEIA MAIS</a>
						</div>
					</div>
				
				</div>
				
				<div id="imghome">
					<img src="image/home/maquina.png" border="0">
				</div>

			<?php
			}
			else
			{
				if ( $url != 'servico' )
				{
					echo '<div id="txtpag">'; //clientes modelo antigo
				}
				else
				{
					echo '<div id="txtpags">';
				}
				
				if ( $url == 'contato' )
				{
					include('contato.php');
				}
				elseif ( $url == 'clientes' )
				{
					include('cliente.php');
				}
				elseif ( $url == 'servico' )
				{
					include('servico.php');
				}
				elseif ( $url == 'empresa' )
				{
					include('empresa.php');
				}
				elseif ( $url == 'logsistema' )
				{
				}
				
				if ( $url != 'servico' )
				{
					echo '</div>';
				
					$cQry = " SELECT *
							  FROM imagens
       						  WHERE IMG_PAGINA = '".( $url == "empresa" ? '1' : ( $url == "servico" ? '2' : ( $url == "contato" ? '3' : '4' ) ) )."'	  
							  LIMIT 0, 1 ";

					$rsc = mysql_query( $cQry, $conexao );

					$num = mysql_num_rows( $rsc );
													
					echo '<div id="imgpag">';
					echo '	<div class="sombra" style="position:relative; top:0px; left:0px;">';
					echo '		<img src="image/fundonovo.png" border="0">';
					
					if ( $num > 0 )
					{
						$ar = mysql_fetch_assoc( $rsc );
						
						echo '<div style="position:absolute; top:10px; left:6px;">';
						echo '<img src="image/pagina/'.$ar['IMG_IMAGEM'].'" border="0">';
						echo '</div>';
					
					}
					
					echo '	</div>';
					echo '</div>';
				}	
			}			
			?>
			
			<div id="footer">
				<div id="txtcont">&copy; Mevatech 2013 - Todos os direitos reservados.</div>           
			</div>
			
		</div>
			
	</div>	
	
<?php
?> 
    
</body>
</html>
    
