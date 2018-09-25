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
              <h1>Usu&aacute;rio <small>Trocar Senha</small></h1>
		<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Altera&ccedil;&atilde;o de senha.
        </div>
		
<?php
  
    $cNome  = "";
    $cLogin  = "";
    $cSenha  = "";
    $cPerfil = "";
    $disabled = "";
    $cBotao = "Cadastrar";
	$do = "edit";

	$cBotao = "Alterar";
	$id     = $_SESSION['ss_codigo'];
		
	$cQry = " SELECT * 
			  FROM lj_usuario
			  WHERE CODIGOUSUARIO = $id ";        
	
	$rsc = mysql_query( $cQry, $conexao );

	$ar = mysql_fetch_assoc($rsc);
	
	$cNome  = $ar['NOME'];
		
	echo '<form method="post" action="gravarbanco.php?url=troca&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    echo '  <div class="form-group">';
    echo '       <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Nome:</label>';
    echo '       <input class="form-control" type="text" name="USU_NOME" id="USU_NOME" '.$disabled.' autofocus required placeholder="Nome do usu&aacute;rio" class="campo" value="'.$cNome.'">';
    echo '  </div>';
  
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Senha:</label>';
    echo '      <input class="form-control" type="password" name="USU_SENHA" id="USU_SENHA" '.$disabled.' required placeholder="Senha" class="campo" value="'.trim( $cSenha ).'">';
    echo '  </div>';

    
	echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
           
    echo '</form>';	

    echo '	</div>
                </div>';
?>
		</div>
    </div><!-- /.row -->
</div><!-- /.page-wrapper --> 

