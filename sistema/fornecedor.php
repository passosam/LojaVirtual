<script type="text/javascript" src="js/jquery-1.3.2.js"></script> 
<script language="javascript" src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"/></script>
<script type="text/javascript">
    jQuery.noConflict();
(function($) {
	$(function() {
	$('#FOR_TELEFONE').mask('(99) 9999-9999'); //telefone
	});
	$(function() {
	$('#FOR_CELULAR').mask('(99) 99999-9999'); //telefone
	});
	$(function() {
	$('#FOR_CEP').mask('99999-999'); //telefone
	});
})(jQuery);
</script>

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
              <h1>Fornecedores <small>Cadastro</small></h1>
		<ol class="breadcrumb">
		  <li><a href="index.php?url=fornecedor"><i class="fa fa-backward"></i> Voltar</a></li>
		  <li><a href="index.php?url=fornecedor&do=new"><i class="fa fa-table"></i> Adicionar</a></li>
		</ol>
		<div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Cadastro de fornecedores do sistema.
        </div>
		
<?php

if ( $do == "" )
{
    ?>		
    <div class="col-lg-6">
    <h2>Lista de Fornecedores</h2>
    <div class="table-responsive">

	<?php

    $cQry = " SELECT *
              FROM lj_fornecedor 
              ORDER BY RAZAOSOCIAL ASC ";
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     

	
    if ( $num > 0 )
    {
        echo '<table class="table table-hover table-striped tablesorter">
                <thead>
                    <tr>
                        <th>C&oacute;digo <i class="fa fa-sort"></i></th>
                        <th>Raz&atilde;o Social <i class="fa fa-sort"></i></th>
                        <th>CNPJ<i class="fa fa-sort"></i></th>
                        <th>IE <i class="fa fa-sort"></i></th>						
                        <th>Telefone <i class="fa fa-sort"></i></th>				
                        <th>Celular <i class="fa fa-sort"></i></th>				
                        <th>Cidade <i class="fa fa-sort"></i></th>	
						<th>Status <i class="fa fa-sort"></i></th>			
                        <th></th>
                    </tr>
                </thead>';
		
		echo '  <tbody>';   

        
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
			echo '	<tr>';
            echo '      <td width=100>'.$ar['CODIGOFORNECEDOR'].' </td>';   
            echo '      <td width=500>'.$ar['RAZAOSOCIAL'].'</td>';
            echo '      <td width=200>'.$ar['CNPJ'].' </td>';   
            echo '      <td width=50>'.$ar['INSCRICAOESTADUAL'].'</td>';
            echo '      <td width=100>'.$ar['TELEFONE'].'</td>';		
            echo '      <td width=100>'.$ar['CELULAR'].'</td>';	
            echo '      <td width=150>'.$ar['CIDADE'].'</td>';		
            echo '      <td width=100 align=center>'.($ar['STATUS'] == 'A' ? 'Ativo' : 'Inativo' ).'</td>';
            echo '      <td width=300  align=center><a href="index.php?url=cliente&do=del&id='.$ar['CODIGOFORNECEDOR'].'"><img src="image/delete.png" border="0"></a>';
            echo '                                  <a href="index.php?url=cliente&do=edit&id='.$ar['CODIGOFORNECEDOR'].'"><img src="image/edit.png" border="0"></a>';
            echo '      </td>';
            echo '  </tr>';
            
        }
        
        echo '  </tbody>';
    }    
    
        echo '</table>';
}
else
{  
    $cRazao  = "";
    $cCNPJ  = "";
    $cCidade = "";
    $cCelular  = "";
    $cTelefone  = "";
    $cIE = "";
	$cLgr = "";
	$cBairro = "";
	$cCep = "";
	$cComp = "";

    $cBotao = "Cadastrar";
    $disabled = "";
	
    $disabled1 = "";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM lj_fornecedor
                  WHERE CODIGOFORNECEDOR = $id ";
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
                       
         $cNome       = $ar['RAZAOSOCIAL'];
         $cLgr   	  = $ar['LOGRADOURO'];
         $cCidade     = $ar['CIDADE'];
         $cCelular    = $ar['CELULAR'];
         $cTelefone   = $ar['TELEFONE'];
         $cCep        = $ar['CEP']; 
         $cComp       = $ar['CCOMPLEMENTO'];		 
         $cCNPJ       = $ar['CNPJ'];
         $cIE         = $ar['INSCRICAOESTADUAL'];
         $cBairro     = $ar['BAIRRO'];
                 
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
        }
        
        echo '<form method="post" action="gravarbanco.php?url=fornecedor&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=fornecedor&do='.$do.'" id="frmCad" name="frmCad">';
    }
   
    echo '<div class="col-lg-6">
			<h2>'.( $do == "new" ? "Incluir" : ( $do == "edit" ? "Alterar" :( $do == "del" ? "Excluir" : "Visualizar") ) ).' Clientes</h2>
			<div class="table-responsive">';
			
	echo '<form method="post" action="gravarbanco.php?url=fornecedor&do='.$do.'" id="formcad" name="formcad">';
       
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">CNPJ:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_CNPJ" id="FOR_CNPJ" '.$disabled.' placeholder="CNPJ" class="campo" value="'.$cCNPJ.'" size="7">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">IE:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_IE" id="FOR_IE" '.$disabled.' placeholder="Inscri&ccedil;&atilde;o Estadual" class="campo" value="'.$cIE.'" size="7">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Raz&atildeo Social:</label>';
    echo '      <input class="form-control" type="text" name="FOR_NOME" id="FOR_NOME" '.$disabled.' autofocus '.$disabled1.' required placeholder="Raz&atilde;o Social" class="campo" value="'.$cRazao.'" size="50">';
    echo '  </div>';
    	
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Endere&ccedil;o:</label>';
    echo '      <input class="form-control" type="text" name="FOR_LGR" id="FOR_LGR" '.$disabled.' placeholder="Endere&ccedil;o do Fornecedor" class="campo" value="'.$cLgr.'" size="50">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Complemento:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_COMP" id="FOR_COMP" '.$disabled.' placeholder="Complemento" class="campo" value="'.$cComp.'" size="7">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Bairro:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_BAIRRO" id="FOR_BAIRRO" '.$disabled.' placeholder="Bairro" class="campo" value="'.$cBairro.'" size="7">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">CEP:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_CEP" id="FOR_CEP" '.$disabled.' placeholder="CEP" class="campo" value="'.$cCep.'" size="15">';
    echo '  </div>';
    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Cidade:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_CIDADE" id="FOR_CIDADE" '.$disabled.'  placeholder="Cidade" class="campo" value="'.$cCidade.'" size="50">';
    echo '  </div>';     

    
    echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Telefone:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_TELEFONE" id="FOR_TELEFONE" '.$disabled.' placeholder="Telefone" class="campo" value="'.$cTelefone.'" size="15">';
    echo '  </div>';
	
	echo '  <div class="form-group">';
    echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Celular:</label>';
    echo '      <input class="form-control1" type="text" name="FOR_CELULAR" id="FOR_CELULAR" '.$disabled.' placeholder="Celular" class="campo" value="'.$cCelular.'" size="15">';
    echo '  </div>';
	
	echo '<div class="form-group">';
	echo '      <label "'.($do == "del" ? 'for="disabledSelect"' : "").'">Status:</label>';
    echo '		<select id="CLI_STATUS" name="CLI_STATUS"class="form-control1" >';
	echo '   		<option value="A">Ativo</option>
					<option value="I">Inativo</option>';
	echo '      </select></div>';
   
    
	echo '<button type="submit" class="btn btn-default">'.($do == 'view' ? 'Voltar' : 'Salvar').'</button>';
    
    echo '</form>';	

    echo '	</div>
                </div>';
   
}  

?>

		</div>
    </div><!-- /.row -->
</div><!-- /.page-wrapper --> 