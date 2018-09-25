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
              <h1>Servi&ccedil;os <small>Cadastro</small></h1>
		<ol class="breadcrumb">
		  <li><a href="index.php?url=tiposervico"><i class="fa fa-backward"></i> Voltar</a></li>
		  <li><a href="index.php?url=tiposervico&do=new"><i class="fa fa-table"></i> Adicionar</a></li>
		</ol>
		<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Cadastro de tipo de servi&ccedil;o do sistema.
        </div>
		
<?php
if ( $do == '' )
{
?>		
    <div class="col-lg-6">
    <h2>Lista de Servi&ccedil;os</h2>
    <div class="table-responsive">

<?php

    
    $cQry = " SELECT *
              FROM apl_tpservico ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     
    if ( $num > 0 )
    {
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Tipo de Servi&ccedil;o <i class="fa fa-sort"></i></th>
                        <th>Descri&ccedil;&atilde;o <i class="fa fa-sort"></i></th>
                    </tr>
                </thead>';
		
        echo '  <tbody>';  
        
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
			echo '	<tr>';			
            echo '      <td width=100>'.$ar['TPS_CODIGO'].' </td>';   
            echo '      <td width=800>'.$ar['TPS_DESCRICAO'].'</td>';
            echo '      <td width=200>'.$ar['TPS_CODIGOTIPOSER'].'</td>';
            echo '      <td width=300><a href="index.php?url=tiposervico&do=del&id='.$ar['TPS_CODIGO'].'"><img src="image/delete.png" border="0"></a>';
            echo '                                  <a href="index.php?url=tiposervico&do=edit&id='.$ar['TPS_CODIGO'].'"><img src="image/edit.png" border="0"></a>';
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
    $cTpservico  = "";
    
    $cBotao = "Cadastrar";
    $disabled = "";
    $disabled1 = "";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM apl_tpservico
                  WHERE TPS_CODIGO = $id ";
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
                       
         $cDescricao = $ar['TPS_DESCRICAO'];
         $cTpservico = $ar['TPS_CODIGOTIPOSER'];
         
 
                 
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
        }
        
        echo '<form method="post" action="gravarbanco.php?url=tiposervico&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=tiposervico&do='.$do.'" id="frmCad" name="frmCad">';
    }
   
    echo '<div class="col-lg-6">
                    <h2>'.( $do == "new" ? "Incluir" : ( $do == "edit" ? "Alterar" :( $do == "del" ? "Excluir" : "Visualizar") ) ).' Servi&ccedil;os</h2>
                    <div class="table-responsive">';

    echo '<form method="post" action="gravarbanco.php?url=tiposervico&do='.$do.'" id="formcad" name="formcad">';
    
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Descri&ccedil;&atilde;o</label>';
    echo '      <input class="form-control" type="text" name="TPS_DESCRICAO" id="TPS_DESCRICAO" '.$disabled.' autofocus '.$disabled1.' required placeholder="Descri&ccedil;&atilde;o" value="'.$cDescricao.'">';
    echo '  </div>';
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Tipo de Servi&ccedil;o:</label>';
    echo '      <input class="form-control" type="text" name="TPS_CODIGOTIPOSER" id="TPS_CODIGOTIPOSER" '.$disabled.' required placeholder="Tipo de Servi&ccedil;o" value="'.$cTpservico.'">';
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
