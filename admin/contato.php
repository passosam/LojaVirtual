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
?>

<script>
function deletar( cod )
{
	if ( confirm( "Deseja realmente excluir esse contato?" ) )
	{
		window.location.href='gravarbanco.php?url=delcontato&id='+cod ;
		return true ;
	}
	
}
</script>

<?php

    $inicio = 10 * ( $pagina - 1 ) ;

    $maximo = 10 ;
    
// selecionando os usuários por nome e ordenando
    $cQry = " SELECT * 
              FROM contato
              ORDER BY CON_CODIGO ";
    $cQry .= 'LIMIT '.$inicio.', '.$maximo.' ';

    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     
    echo '<table width=800 align=center border=0>';
    
    echo '<thead>';
    
    echo '  <tr>';
    echo '      <td colspan="5" class=CorContato>Contatos</td>';
    echo '  </tr>';
        
    echo '  <tr>';
    echo '      <td colspan="5" align="center"><b><a href="index.php?url=contato" class="menn1">Listar</a></b><br><br></td>';
    echo '  </tr>';

    if ( $num > 0 )
    {

        echo '  <tr>';
        echo '      <td class="TitleCol">Nome</td>';
        echo '      <td class="TitleCol">E-mail</td>';
        echo '      <td class="TitleCol">Assunto</td>';
        echo '      <td class="TitleCol">Mensagem</td>';
        echo '	<td></td>';
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
            
            echo '      <td class="TitleRow">'.$ar['CON_NOME'].'</td>';
            echo '      <td class="TitleRow">'.$ar['CON_EMAIL'].'</td>';
            echo '      <td class="TitleRow">'.$ar['CON_ASSUNTO'].'</td>';
            echo '      <td class="TitleRowjus">'.$ar['CON_MENSAGEM'].'</td>';
            echo '      <td width=100  align=center><a href="javascript:deletar('.$ar['CON_CODIGO'].')"><img src=../image/excluir.png border="0"></a>';
            echo '      </td>';
            
            echo '  </tr>';
            
            $bZeb = !$bZeb; 
        }
        
        echo '  </tbody>';
    }    
    
    $menos = $pagina - 1 ;

    $cQry = " SELECT *
              FROM contato ";
        
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
            echo '<a href="index.php?url=contato&pagina='.$menos.'" class="pag">anterior</a>&nbsp; '; 
        }   
        
        for($i=1;$i <= $pgs;$i++) 
        { 
            if($i != $pagina) 
            { 
                echo '<a href="index.php?url=contato&pagina='.($i).'" class="pag">'.$i.'</a> | '; 
            } 
            else 
            { 
                echo ' <strong><b class="pag">'.$i.'</b></strong> | '; 
            } 
        }   
        if($mais <= $pgs) 
        { 
            echo ' <a href="index.php?url=contato&pagina='.$mais.'" class="pag">pr&oacute;xima</a>'; 
        } 
    } 

    
    echo '</td></tr>';

    echo '</table>';
}
 

?>
