<?php
// Incluindo conexão ao banco de dados
include ('conexao.php');

if ( isset( $_GET['do'] ) )
{
    $do = $_GET['do'];
}
else
{
    $do = "";
}

?>

<div id="page-wrapper">
	 <div class="row">
	  <div class="col-lg-12">
              <h1>Despesas <small>Cadastro</small></h1>
		<ol class="breadcrumb">
		  <li><a href="index.php?url=tipodespesa"><i class="fa fa-backward"></i> Voltar</a></li>
		  <li><a href="index.php?url=tipodespesa&do=new"><i class="fa fa-table"></i> Adicionar</a></li>
		</ol>
		<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Cadastro de tipos de despesas do sistema.
        </div>
		
<?php
if ( $do == '' )
{
?>		
    <div class="col-lg-6">
    <h2>Lista de Despesas</h2>
    <div class="table-responsive">

<?php
 
    $cQry = " SELECT *
              FROM apl_tipodespesa ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
    
    if ( $num > 0 )
    {
        
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Descri&ccedil;&atilde;o <i class="fa fa-sort"></i></th>
                    </tr>
                </thead>';
		
        echo '  <tbody>';  
        
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
			echo '	<tr>';			
            echo '      <td width=100>'.$ar['TIP_CODIGO'].' </td>';   
            echo '      <td width=800>'.$ar['TIP_DESCRICAO'].'</td>';
            echo '      <td width=300  align=center><a href="index.php?url=tipodespesa&do=del&id='.$ar['TIP_CODIGO'].'"><img src="image/delete.png" border="0"></a>';
            echo '                                  <a href="index.php?url=tipodespesa&do=edit&id='.$ar['TIP_CODIGO'].'"><img src="image/edit.png" border="0"></a>';
            echo '      </td>';
            echo '  </tr>';
            
        }
        
        echo '  </tbody>';
    }    
    
    echo '</table>';
    
}
else
{  
    $cDescricao  = "";
        
    $cBotao = "Cadastrar";
    $disabled = "";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM apl_tipodespesa
                  WHERE TIP_CODIGO = $id ";
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
                       
         $cDescricao = $ar['TIP_DESCRICAO'];
                         
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
        }
        
        echo '<form method="post" action="gravarbanco.php?url=tipodespesa&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=tipodespesa&do='.$do.'" id="frmCad" name="frmCad">';
    }
   
    echo '<div class="col-lg-6">
                    <h2>'.( $do == "new" ? "Incluir" : ( $do == "edit" ? "Alterar" :( $do == "del" ? "Excluir" : "Visualizar") ) ).' Despesas</h2>
                    <div class="table-responsive">';

    echo '<form method="post" action="gravarbanco.php?url=tipodespesa&do='.$do.'" id="formcad" name="formcad">';    
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Descri&ccedil;&atilde;o:</label>';
    echo '      <input class="form-control" type="text" name="TIP_DESCRICAO" id="TIP_DESCRICAO" autofocus '.$disabled.' required placeholder="Descri&ccedil;&atilde;o da despesa" class="campo" value="'.$cDescricao.'">';
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