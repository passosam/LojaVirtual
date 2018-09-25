<?php
	session_start();
    include ( 'conexao.php' );
?>
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="charset" content="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    

    <title>Loja Virtual - Sistema</title>	
	<link rel="shortcut icon" href="../image/favicon.png" type="image/x-icon" />

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
  </head>

  <body>
      
   <?php
   
    if ( isset ( $_GET ['do'] ) )
    {
        $do = $_GET [ 'do' ];
		
    }    
    else
    {
        $do= "";
    }  
	
	if ( isset( $_GET['url'] ) )
	{
		$url = $_GET['url'];
	}
	else
	{
		$url = '';
	}
    
    if ( $do == "logoff" ||  empty($_SESSION['ss_nome']) )
    {
       $_SESSION['ss_logado'] = false;
        echo '<script type="text/javascript">location.href="../index.php";</script>'; 
    }
	
    else
    {
   
   ?>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="image/logo.png"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            
          <ul class="nav navbar-nav side-nav">
			<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-edit"></i> Ordem Servi&ccedil;o <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="index.php?url=os&do=new">Abrir O.S.</a></li>
				<li><a href="index.php?url=os&do=acomp">Acompanhar O.S.</a></li>
                <li><a href="index.php?url=os&do=fec">Fechar O.S.</a></li>
              </ul>
            </li>
			
		<?php 
		if ($_SESSION['ss_perfil'] == '1')
		{?>	
	    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-thumb-tack"></i> Cadastros<b class="caret"></b></a>
              <ul class="dropdown-menu">
                  <li><a href="index.php?url=fornecedor">Fornecedor</a></li>
                  <li><a href="index.php?url=equipamento">Produto</a></li>
                  <li><a href="index.php?url=pecas">teste</a></li>                  
                  <li><a href="index.php?url=tipodespesa">Tipos de Despesas</a></li>				               
                  <li><a href="index.php?url=tiposervico">Tipos de Servi&ccedil;os</a></li>
              </ul>
            </li>         
                
	    <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-star"></i> Relat&oacute;rios <b class="caret"></b></a>
              <ul class="dropdown-menu">
				<li><a href="index.php?url=os&do=rel">Ordem de Servi&ccedil;o</a></li> 
              </ul>
            </li>
			
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-star"></i> Gr&aacute;ficos <b class="caret"></b></a>
              <ul class="dropdown-menu">
				<li><a href="index.php?url=grafico">T&eacute;cnicos x Horas</a></li>
				<li><a href="index.php?url=graficoeqp">Equipamentos x Horas</a></li> 
				<li><a href="index.php?url=graficoos">O.S. x Status</a></li>
              </ul>
            </li>
           
			
            <li><a href="index.php?url=usuario"><i class="fa fa-users"></i> Usu&aacute;rios</a><li> 
<?php } ?> 

		 
		           </ul>
          <ul class="nav navbar-nav navbar-right navbar-user">
            
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['ss_nome']; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><?php echo '<a href="index.php?url=troca">'; ?><i class="fa fa-clipboard"></i> Trocar Senha</a></li>
                <li class="divider"></li>
                <li><a href="index.php?do=logoff"><i class="fa fa-power-off"></i> Sair</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
	<?php
	
	if ( $url != "")
	{
		echo '<div id="page-wrapper">

        <div class="row">';
		
		if ( $url == "pecas" )
		{
			include('pecas.php');
		}
		elseif ( $url == "tiposervico" )
		{
			include('tiposervico.php');
		}	
		elseif ( $url == "tipodespesa" )
		{
			include('tipodespesa.php');
		}	
		elseif ( $url == "usuario" )
		{
			include('usuario.php');
		}	
		elseif ( $url == "fornecedor" )
		{
			include('fornecedor.php');
		}
		elseif ( $url == "equipamento" )
		{
			include('equipamento.php');
		}	
		elseif ( $url == "os" )
		{
			include('os.php');
		}	
		elseif ( $url == "troca" )
		{
			include('troca.php');
		}	
		elseif ( $url == "relos" )
		{
			include('os.php');
		}	
		elseif ( $url == "grafico" )
		{
			echo '<script type="text/javascript">window.open("grafico.php")</script>';
		}	
		elseif ( $url == "graficoeqp" )
		{
			echo '<script type="text/javascript">window.open("graficoeqp.php")</script>';
		}	
		elseif ( $url == "graficoos" )
		{
			echo '<script type="text/javascript">window.open("graficoos.php")</script>';
		}	
		echo '</div></div>
			  </div>';
	}
	?>
    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="js/morris/chart-data-morris.js"></script>
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>

    <?php
    }
    ?>
  </body>
</html>
