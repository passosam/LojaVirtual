<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>  
<script src="../js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function()
   {
      $("#frmCad").validate({
         rules: {
            IMG_CODIGO:   { required: true },
            IMG_PAGINA:   { required: true },
            IMG_IMAGEM: required
                        
         },
         messages: {
            
           IMG_PAGINA:   { required: '<br><b class="Mensagem">Selecione a p&aacute;gina</b>' },
           IMG_IMAGEM:   { required: '<br><b class="Mensagem">Selecione uma imagem </b>'}
            
         }
      });
   });
</script>
<?php



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
    
    $inicio = 10 * ( $pagina - 1 ) ;

    $maximo = 10 ;
    
    $cQry = " SELECT *
              FROM imagens ";      
    
    $cQry .= 'LIMIT '.$inicio.', '.$maximo.' ';
    
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
    
    echo '<table width=50% border="0" align = "center">';
            
    echo '  <tr>';
    echo '      <td colspan="3" class=CorContato>Lista de Imagens</td>';
    echo '  </tr>';

    echo '  <tr>';
    echo '      <td colspan="3" align="center"><b><a href=index.php?url=imagem&do=new class="menn1">Adicionar | </a><a href=index.php?url=imagem class="menn1">Listar</a></b><br><br></td>';
    echo '  </tr>';
    
    if ( $num > 0 )
    {    
              
        echo '	  <tr class="tabela">';
        echo '      <th class="TitleCol">C&oacute;digo</th>'; 
        echo '      <th class="TitleCol">P&aacute;gina</th>';        
        echo '      <th class="TitleCol">Imagem</th>';
        echo '      <th></th>';
        echo '    </tr>';
     
            
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
            
            echo '      <td class="TitleRow" width="5" align=center>'.$ar['IMG_CODIGO'].'</td>';
            echo '      <td class="TitleRow" width="60%">'.( $ar['IMG_PAGINA'] == '1' ? 'Empresa' : ( $ar['IMG_PAGINA'] == '2' ? 'Servi&ccedil;os' : ( $ar['IMG_PAGINA'] == '3' ? 'Contato' : 'Cliente' ) ) ).'</td>';
            echo '      <td align=center><img width=80%  src="../image/pagina/'.$ar['IMG_IMAGEM'].'" border="0" /></td>';
            echo '      <td align=center     width="30"><a href="index.php?url=imagem&do=del&id='.$ar['IMG_CODIGO'].'"><img src=../image/excluir.png border="0"></a>';
            echo '      </td>';
            echo '  </tr>';
            
             $bZeb = !$bZeb; 

        }
        
        echo '  </tbody>';
    }      
    
    $menos = $pagina - 1 ;

     $cQry = " SELECT *
               FROM imagens ";
        
    $rsc = mysql_query( $cQry, $conexao );
    
    $nNum  = mysql_num_rows( $rsc );
    $mais   = $pagina + 1 ;
    $maximo = 10 ;
    $pgs    = ceil( $nNum / $maximo ) ;

    echo '<tr><td colspan=5 align=center>';
    
    if( $pgs > 1 ) 
    {   
        echo "<br />";    
        
        if($menos > 0) 
        { 
            echo '<a href="index.php?url=imagem&pagina='.$menos.'">anterior</a>&nbsp; '; 
        }   
        
        for($i=1;$i <= $pgs;$i++) 
        { 
            if($i != $pagina) 
            { 
                echo '<a href="index.php?url=imagem&pagina='.($i).'">'.$i.'</a> | '; 
            } 
            else 
            { 
                echo ' <strong>'.$i.'</strong> | '; 
            } 
        }   
        if($mais <= $pgs) 
        { 
            echo ' <a href="index.php?url=imagem&pagina='.$mais.'">pr&oacute;xima</a>'; 
        } 
    } 
    
    echo '</td></tr>';
    echo '</table>';
}
elseif ( $do != "" )
{    
    $cPagina     = "";
    $cImagem  = "";
    $disabled = "";
    $cBotao = "Cadastrar";
    
    if ( $do == "del" )
    {       
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM imagens
                  WHERE IMG_CODIGO = $id ";
           
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
        
        $cPagina   = $ar['IMG_PAGINA'];
        $cImagem   = $ar['IMG_IMAGEM' ]; 
                
        $cBotao = "Excluir";
        $disabled = "disabled";
        
        echo '<form method="post" action="gravarbanco.php?url=imagem&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=imagem&do='.$do.'" id="frmCad" name="frmCad" enctype="multipart/form-data">';
    }
        
    echo '<table width=50% border="0" align="center">';

    echo '  <tr>';
    echo '      <td colspan="2" class=CorContato>'.$cBotao.' Imagem</td>';
    echo '  </tr>';
    
    echo '  <tr>';
    echo '      <td colspan="2" align=center><a href=index.php?url=cliente class="menn1">Listar</a><br><br></td>';
    echo '  </tr>';

    echo '  <tr>';
    echo '      <td class="CorLinha">Selecione a P&aacute;gina:</td>';
    echo '      <td><select name="IMG_PAGINA" id="IMG_PAGINA" '.$disabled.' value="'.$cPagina.'" class="campo" title="P&aacute;gina">
                <option value="0">Selecione a op&ccedil;&atilde;o</option>
                <option value="1">Empresa</option>
                <option value="2">Servi&ccedil;os</option>
                <option value="3">Contato</option>
                <option value="4">Clientes</option>
                </select></td>';
    echo '  </tr>';
        
    echo '  <tr>';
    echo '      <td class="CorLinha">Imagem:</td>';
    echo '      <td><input type="file" name="IMG_IMAGEM" id="IMG_IMAGEM" '.$disabled.' value="'.$cImagem.'" class="campo" title="Imagem"></td>';
    echo '  </tr>';

    echo '  <tr>';
    echo '      <td colspan="2" align=center><input type="submit" value="'.$cBotao.'" name="botao" id="botao" class="submit"></td>';
    echo '  </tr>';

    echo '</table>';

    echo '</form>';
}    
?>   
</html>

