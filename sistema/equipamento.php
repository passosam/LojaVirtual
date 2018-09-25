<?php
// Incluindo conexão ao banco de dados
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
              <h1>Equipamentos <small>Cadastro</small></h1>
		<ol class="breadcrumb">
		  <li><a href="index.php?url=equipamento"><i class="fa fa-backward"></i> Voltar</a></li>
		  <li><a href="index.php?url=equipamento&do=new"><i class="fa fa-table"></i> Adicionar</a></li>
		</ol>
		<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Cadastro de equipamento do sistema.
        </div>
		
<?php

if ( $do == "" )
{
	?>		
    <div class="col-lg-6">
    <h2>Lista de Equipamentos</h2>
    <div class="table-responsive">

	<?php
    
    $cQry = " SELECT e.*,c.CLI_NOME
              FROM apl_equipamento e
					INNER JOIN apl_cliente c
					ON e.cli_codigo = c.cli_codigo              
              ORDER BY e.EQP_NOME ASC ";
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     
    
    if ( $num > 0 )
    {
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Nome <i class="fa fa-sort"></i></th>
                        <th>Modelo <i class="fa fa-sort"></i></th>
                        <th>S&eacute;rie <i class="fa fa-sort"></i></th>						
                        <th>SAP <i class="fa fa-sort"></i></th>								
                        <th>Cliente <i class="fa fa-sort"></i></th>							
                        <th>Status <i class="fa fa-sort"></i></th>			
                        <th></th>
                    </tr>
                </thead>';
		
		echo '  <tbody>';   
        
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
			echo '	<tr>';			
            echo '      <td width=150>'.$ar['EQP_CODIGO'].' </td>';   
            echo '      <td width=150>'.$ar['EQP_NOME'].'</td>';
            echo '      <td width=200>'.$ar['EQP_MODELO'].'</td>';
            echo '      <td align=center width=100>'.$ar['EQP_SERIE'].' </td>';   
            echo '      <td align=center width=100>'.$ar['EQP_CODIGOEQP'].'</td>';
            echo '      <td width=500>'.$ar['CLI_NOME'].'</td>';
			echo '      <td width=100 align=center>'.($ar['EQP_STATUS'] == 'A' ? 'Ativo' : 'Inativo' ).'</td>';
            echo '      <td width=300><a href="index.php?url=equipamento&do=del&id='.$ar['EQP_CODIGO'].'"><img src="image/delete.png" border="0"></a>';
            echo '                                  <a href="index.php?url=equipamento&do=edit&id='.$ar['EQP_CODIGO'].'"><img src="image/edit.png" border="0"></a>';
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
    $cModelo  = "";
    $cSerie = "";
    $cCodigoeqp  = "";
    $cCliente  = "";
    

    $cBotao = "Cadastrar";
    $disabled = "";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM apl_equipamento
                  WHERE EQP_CODIGO = $id ";
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
                       
         $cNome       = $ar['EQP_NOME'];
         $cModelo     = $ar['EQP_MODELO'];
         $cSerie      = $ar['EQP_SERIE'];
         $cCodigoeqp  = $ar['EQP_CODIGOEQP'];
         $cCliente    = $ar['CLI_CODIGO'];
 
                 
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
        }
        
        echo '<form method="post" action="gravarbanco.php?url=equipamento&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=equipamento&do='.$do.'" id="frmCad" name="frmCad">';
    }
	
    echo '<div class="col-lg-6">
			<h2>'.( $do == "new" ? "Incluir" : ( $do == "edit" ? "Alterar" :( $do == "del" ? "Excluir" : "Visualizar") ) ).' Equipamento</h2>
			<div class="table-responsive">';
			
	echo '<form method="post" action="gravarbanco.php?url=cliente&do='.$do.'" id="formcad" name="formcad">';
       
   
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Nome:</label>';
    echo '      <input class="form-control1" type="text" name="EQP_NOME" id="EQP_NOME" '.$disabled.' autofocus placeholder="Nome do Equipamento" class="campo" value="'.$cNome.'" size="50">';
    echo '  </div>';
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Modelo:</label>';
    echo '      <input class="form-control1" type="text" name="EQP_MODELO" id="EQP_MODELO" '.$disabled.' placeholder="Modelo" class="campo" value="'.$cModelo.'" size="50">';
    echo '  </div>';
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">S&eacute;rie:</label>';
    echo '      <input class="form-control1" type="text" name="EQP_SERIE" id="EQP_SERIE" '.$disabled.' placeholder="S&eacute;rie" class="campo" value="'.$cSerie.'" size="15">';
    echo '  </div>';
     
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">SAP:</label>';
    echo '      <input class="form-control1" type="text" name="EQP_CODIGOEQP" id="EQP_CODIGOEQP" '.$disabled.' placeholder="SAP Equipamento" class="campo" value="'.$cCodigoeqp.'" size="15">';
    echo '  </div>';	
	
	echo '<div class="form-group">';
	echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Status:</label>';
    echo '		<select id="EQP_STATUS" name="EQP_STATUS"class="form-control1" >';
	echo '   		<option value="A">Ativo</option>
					<option value="I">Inativo</option>';
	echo '      </select></div>';
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Cliente:</label>';
    echo '      <select class="form-control1" name="CLI_CODIGO" id="CLI_CODIGO" '.$disabled.' title="Cliente" class="campo">';
               
    $cQryCid = "SELECT *
                FROM apl_cliente  " ;

    $rsccid = mysql_query( $cQryCid, $conexao );  

    while ( $arcid = mysql_fetch_assoc($rsccid) )
    {
        echo '<option value= "'.$arcid['CLI_CODIGO'].'"> '.$arcid['CLI_NOME'].'</option>';
    }
    
    echo '  </select>
           
            </div>';

    echo '  </tr>';	
   
	echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';          
   
    echo '</form>';	

    echo '	</div>
            </div>';
}  
?>
		</div>
    </div><!-- /.row -->
</div><!-- /.page-wrapper --> 
