<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>  
<script src="../js/jquery.validate.js" type="text/javascript"></script>

<script type="text/javascript">
   $(document).ready(function()
   {
      $("#frmCad").validate({
         rules: {
            USU_NOME:   { required: true },
            USU_SENHA:  { required: true }
         },
         messages: {
            USU_NOME:   { required: '<br><b class="Mensagem">Informe seu nome</b>'   },
            USU_SENHA:  { required: '<br><b class="Mensagem">Informe a senha</b>' }
         }
      });
   });
</script>

<script language="javascript">
    $(function() {
        $('#USU_SENHA').pstrength();
    });
</script>

<?php

// Criando Formulario de Usuários

$bZeb = false;
include ('../conexao.php');

if ( isset( $_GET['do'] ) )
{
    $do = $_GET['do'];
}
else
{
    $do = "";
}

if ( isset( $_GET["pagina"] ) )
{    
    $pagina = $_GET["pagina"];
}
else
{
    $pagina = 1;
}


if ( $do == "" )
{

    $inicio = 30 * ( $pagina - 1 ) ;

    $maximo = 30 ;
    
// selecionando os usuários por nome e ordenando
    $cQry = " SELECT * 
              FROM usuario
              ORDER BY USU_CODIGO ";
    $cQry .= 'LIMIT '.$inicio.', '.$maximo.' ';

    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     
    echo '<table width=500 align=center border=0>';
    
    echo '<thead>';
    
    echo '  <tr>';
    echo '      <td colspan="3" class="CorContato">Lista de Usu&aacute;rios</td>';
    echo '  </tr>';
        
    echo '  <tr>';
    echo '      <td colspan="3" align="center"><b><a href="index.php?url=usuario&do=new" class="menn1">Adicionar | </a> <a href="index.php?url=usuario&do=" class="menn1">Listar </a></b><br><br></td>';
    echo '  </tr>';

    if ( $num > 0 )
    {

        echo '  <tr>';
	    echo '      <td class="TitleCol">C&oacute;digo</td>';
        echo '      <td class="TitleCol">Nome</td>';
        echo '      <td class="TitleCol"></td>';
        echo '  </tr>';
        echo '  </thead>';
        
        echo '  <tbody>';  
        
        while ( $ar = mysql_fetch_assoc( $rsc ) )
        {
            
            if ( $bZeb )
            {
                echo '<tr bgcolor="#FFFFFF">';
            }
            else
            {
				echo '<tr bgcolor="#c9c6e3">';
            }
            
			echo '      <td class="TitleRow" width="5" align=center>'.$ar['USU_CODIGO'].'</td>';
            echo '      <td class="TitleRow" width="80%">'.$ar['USU_NOME'].'</td>';
            echo '      <td align=center     width="100"><a href="index.php?url=usuario&do=del&id='.$ar['USU_CODIGO'].'"><img src=../image/excluir.png border="0"></a>';
            echo '                                      <a href="index.php?url=usuario&do=edit&id='.$ar['USU_CODIGO'].'"><img src=../image/editar.png border="0"></a>';
            echo '      </td>';
            echo '  </tr>';
            
            $bZeb = !$bZeb; 
        }
        
        echo '  </tbody>';
    }    
    
    $menos = $pagina - 1 ;

    $cQry = " SELECT *
              FROM usuario ";
        
    $rsc = mysql_query( $cQry, $conexao );

    
    $nNum  = mysql_num_rows( $rsc );
    $mais   = $pagina + 1 ;
    $maximo = 30 ;
    $pgs    = ceil( $nNum / $maximo ) ;

    echo '<tr><td colspan=3 align=center>';
    
    if( $pgs > 1 ) 
    {   
        echo "<br />";    
        
        if($menos > 0) 
        { 
            echo '<a href="index.php?url=usuario&pagina='.$menos.'" class="pag">anterior</a>&nbsp; '; 
        }   
        
        for($i=1;$i <= $pgs;$i++) 
        { 
            if($i != $pagina) 
            { 
                echo '<a href="index.php?url=usuario&pagina='.($i).'" class="pag">'.$i.'</a> | '; 
            } 
            else 
            { 
                echo ' <strong><b class="pag">'.$i.'</b></strong> | '; 
            } 
        }   
        if($mais <= $pgs) 
        { 
            echo ' <a href="index.php?url=usuario&pagina='.$mais.'" class="pag">pr&oacute;xima</a>'; 
        } 
    } 

    
    echo '</td></tr>';

    echo '</table>';
}
else
{  
    $cNome  = "";
    $cSenha = "";
    $disabled = "";
    $cBotao = "Cadastrar";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM usuario
                  WHERE USU_CODIGO = $id ";
        
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
        
        $cNome  = $ar['USU_NOME'];

        
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
            $cSenha = $ar['USU_SENHA'];
        }
        
        echo '<form method="post" action="gravarbanco.php?url=usuario&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=usuario&do='.$do.'" id="frmCad" name="frmCad">';
    }
   
    echo '<table width=400 align=center border=0>';

    echo '  <tr>';
    echo '      <td colspan="2" class=CorContato>'.$cBotao.' Usu&aacute;rio</td>';
    echo '  </tr>';
    
    echo '  <tr>';
    echo '      <td colspan="2" align=center><a href="index.php?url=usuario&do=" class="menn1">Listar </a><br><br></td>';
    echo '  </tr>';

    echo '  <tr>';
    echo '      <td class="CorLinha">Login:</td>';
    echo '      <td><input type="text" name="USU_NOME" id="USU_NOME" '.$disabled.' title="Nome do usu&aacute;rio" class="campo" value="'.$cNome.'" size="40"></td>';
    echo '  </tr>';

  
    echo '  <tr>';
    echo '      <td class="CorLinha">Senha:</td>';
    echo '      <td><input type="password" name="USU_SENHA" id="USU_SENHA" '.$disabled.' title="Senha do usu&aacute;rio" class="campo" value="'.trim( $cSenha ).'" size="40"></td>';
    echo '  </tr>';
    
    echo '  <tr>';
    echo '      <td colspan="2" align=center><input type="submit" value="'.$cBotao.'" name="botao" id="botao" class="submit"></td>';
    echo '  </tr>';

    echo '</table>';

    echo '</form>';
}    

?>


