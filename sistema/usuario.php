<?php

include ('conexao.php');

if ( isset( $_GET['do'] ) )
{
    $do = $_GET['do'];
    
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
    $do = "";
}
	
?>

<div id="page-wrapper">
	 <div class="row">
	  <div class="col-lg-12">
              <h1>Usu&aacute;rio <small>Cadastro</small></h1>
		<ol class="breadcrumb">
		  <li><a href="index.php?url=usuario"><i class="fa fa-backward"></i> Voltar</a></li>
		  <?php
		  if ($_SESSION['ss_perfil'] == '1')
		  {
			echo '<li><a href="index.php?url=usuario&do=new"><i class="fa fa-table"></i> Adicionar</a></li>';
		}
		  ?>
		</ol>
		<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Cadastro padr&atilde;o dos usu&aacute;rios do sistema.
        </div>
		
<?php
if ( $do == '' )
{
?>		
    <div class="col-lg-6">
        <h2>Lista de Usu&aacute;rio</h2>
    <div class="table-responsive">

<?php

    $cQry = " SELECT u.*, p.DESCRICAO as PERFIL 
              FROM lj_usuario u
				   inner join lj_perfil p on
				    p.CODIGOPERFIL = u.CODIGOPERFIL  ";
			  
	if ( $_SESSION['ss_perfil'] <> '1' )
	{
		$cQry .= " WHERE CODIGOUSUARIO =".$_SESSION['ss_codigo'];	
	}
        $cQry .= " ORDER BY CODIGOUSUARIO ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );    

    if ( $num > 0 )
    {
		echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Nome <i class="fa fa-sort"></i></th>
                        <th>Login <i class="fa fa-sort"></i></th>                        
                        <th>Perfil <i class="fa fa-sort"></i></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
        
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
            echo '	<tr>';            
	        echo '      <td width="10%" align=center>'.$ar['CODIGOUSUARIO'].'</td>';
            echo '      <td width="30%">'.$ar['NOME'].'</td>';
            echo '      <td width="30%">'.$ar['LOGIN'].'</td>';
            echo '      <td width="20%">'.$ar['PERFIL'].'</td>';
            echo '      <td align=center  width="20%"><a href="index.php?url=usuario&do=del&id='.$ar['CODIGOUSUARIO'].'"><img src="image/delete.png" border="0"></a>';
            echo '                                      '.($_SESSION['ss_perfil'] == '1' ? '<a href="index.php?url=usuario&do=edit&id='.$ar['CODIGOUSUARIO'].'"><img src="image/edit.png" border="0">':'').'</a>';
            echo '      </td>';
            echo '  </tr>';
            
        }
        
        echo '  </tbody>';
    }    
   
    echo '</table>';
}
else
{  
    $cNome  = "";
    $cLogin  = "";
    $cSenha  = "";
	$cEmail  = "";
    $cPerfil = "";
    $disabled = "";
    $cBotao = "Cadastrar";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM lj_usuario
                  WHERE CODIGOUSUARIO = $id ";        
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
		
		
	    $cNome  = $ar['NOME'];		
	    $cLogin  = $ar['LOGIN'];
        $cEmail  = $ar['EMAIL'];
        
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
            $cSenha = $ar['SENHA'];
        }
        
        echo '<form method="post" action="gravarbanco.php?url=usuario&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=usuario&do='.$do.'" id="frmCad" name="frmCad">';
    }
	
	$cQryPerfil = " SELECT * 
					FROM lj_perfil ";        
	$rscPerfil = mysql_query( $cQryPerfil, $conexao );
	    
    echo '<div class="col-lg-6">
             <h2>'.( $do == "new" ? "Incluir" : ( $do == "edit" ? "Alterar" :( $do == "del" ? "Excluir" : "Visualizar") ) ).' Usu&aacute;rio</h2>
          <div class="table-responsive">';

    echo '<form method="post" action="gravarbanco.php?url=usuario&do='.$do.'" id="formcad" name="formcad">';

    echo '  <div class="form-group">';
    echo '       <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Nome:</label>';
    echo '       <input class="form-control" type="text" name="USU_NOME" id="USU_NOME" '.$disabled.' autofocus required placeholder="Nome do usu&aacute;rio" class="campo" value="'.$cNome.'">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">E-mail:</label>';
    echo '      <input class="form-control" type="text" name="USU_EMAIL" id="USU_EMAIL" '.$disabled.' required placeholder="E-mail" class="campo" value="'.$cEmail.'">';
    echo '  </div>';

    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Login:</label>';
    echo '      <input class="form-control" type="text" name="USU_LOGIN" id="USU_LOGIN" '.$disabled.' required placeholder="Login" class="campo" value="'.$cLogin.'">';
    echo '  </div>';
  
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Senha:</label>';
    echo '      <input class="form-control" type="password" name="USU_SENHA" id="USU_SENHA" '.$disabled.' required placeholder="Senha" class="campo" value="'.trim( $cSenha ).'">';
    echo '  </div>';
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Perfil:</label>';
    echo '      <select class="form-control1" name="USU_PERFIL" id="USU_PERFIL" '.$disabled.' required placeholder="Perfil" class="campo" >';
	
    while ($arPerfil = mysql_fetch_assoc($rscPerfil))
	{
		echo'oi';
		echo '<option value = "'.$arPerfil['CODIGOPERFIL'].'">'.$arPerfil['DESCRICAO'].'</option>';
	}	
	
    echo '       </select>';
    echo '  </div>';
    
	echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
           
    echo '</form>';	

    echo '	</div>
                </div>';

}    

?>

		</div>
    </div><!-- /.row -->
</div><!-- /.page-wrapper --> 

