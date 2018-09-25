<script type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

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

<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>  


<?php

    $inicio = 20 * ( $pagina - 1 ) ;

    $maximo = 20 ;
    
    $cQry = " SELECT * 
              FROM servico
              ORDER BY SER_CODIGO DESC ";
    $cQry .= 'LIMIT '.$inicio.', '.$maximo.' ';

    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     
    echo '<table width=600 align=center border=0>';
    
    echo '<thead>';
    
    echo '  <tr>';
    echo '      <td colspan="2" class=CorContato>Lista de Servi&ccedil;o</td>';
    echo '  </tr>';
        
    echo '  <tr>';
    echo '      <td colspan="2" align="center"><b><a href=index.php?url=servico&do=new class="menn1">Adicionar | </a><a href="index.php?url=servico" class="menn1">Listar</a></b><br><br></td>';
    echo '  </tr>';

    if ( $num > 0 )
    {

        echo '  <tr>';
        echo '      <td class="TitleCol">Descri&ccedil;&atilde;o</td>';
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
            
            echo '      <td width=500 class="TitleRowjus">'.stripcslashes($ar['SER_DESCRICAO']).'</td>';           
            echo '      <td width=100  align=center><a href="index.php?url=servico&do=del&id='.$ar['SER_CODIGO'].'"><img src=../image/excluir.png border="0"></a>';
            echo '                                  <a href="index.php?url=servico&do=edit&id='.$ar['SER_CODIGO'].'"><img src=../image/editar.png border="0"></a>';
            echo '      </td>';
            echo '  </tr>';
            
            $bZeb = !$bZeb; 
        }
        
        echo '  </tbody>';
    }    
    
    $menos = $pagina - 1 ;

    $cQry = " SELECT *
              FROM servico ";
        
    $rsc = mysql_query( $cQry, $conexao );

    
    $nNum  = mysql_num_rows( $rsc );
    $mais   = $pagina + 1 ;
    $maximo = 20 ;
    $pgs    = ceil( $nNum / $maximo ) ;

    echo '<tr><td colspan=3 align=center>';
    
    if( $pgs > 1 ) 
    {   
        echo "<br />";    
        
        if($menos > 0) 
        { 
            echo '<a href="index.php?url=servico&pagina='.$menos.'" class="pag">anterior</a>&nbsp; '; 
        }   
        
        for($i=1;$i <= $pgs;$i++) 
        { 
            if($i != $pagina) 
            { 
                echo '<a href="index.php?url=servico&pagina='.($i).'" class="pag">'.$i.'</a> | '; 
            } 
            else 
            { 
                echo ' <strong><b class="pag">'.$i.'</b></strong> | '; 
            } 
        }   
        if($mais <= $pgs) 
        { 
            echo ' <a href="index.php?url=servico&pagina='.$mais.'" class="pag">pr&oacute;xima</a>'; 
        } 
    } 
    
    echo '</td></tr>';

    echo '</table>';
}
else
{  
   
    $cDescricao  = "";
    $disabled = "";
    $cBotao = "Cadastrar";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM servico
                  WHERE SER_CODIGO = $id ";
        
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
        
        $cDescricao  = stripcslashes($ar['SER_DESCRICAO']); 
                
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
        }
        
        echo '<form method="post" action="gravarbanco.php?url=servico&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=servico&do='.$do.'" id="frmCad" name="frmCad">';
    }
   
    echo '<table width=500 align=center border=0>';
    
    echo '  <tr>';
    echo '      <td colspan="2" class=CorContato>'.$cBotao.' Servi&ccedil;o</td>';
    echo '  </tr>';
    
    echo '  <tr>';
    echo '      <td colspan="2" align=center><a href=index.php?url=servico class="menn1">Listar</a><br><br></td>';
    echo '  </tr>';
    
    echo '  <tr>';
    echo '      <td class="CorLinha">Descri&ccedil;&atilde;o:</td>';
    echo '      <td><textarea name = "SER_DESCRICAO" rows = "05" cols = "67" id="SER_DESCRICAO" '.$disabled.' title="Descri&ccedil;&atilde;o" class="campo"  size="70">'.str_replace("<br />", "",stripcslashes($cDescricao)).'</textarea></td>';
    echo '  </tr>';
      
    echo '  <tr>';
    echo '      <td colspan="2" align=center><input type="submit" value="'.$cBotao.'" name="botao" id="botao" class="submit"></td>';
    echo '  </tr>';

    echo '</table>';

    echo '</form>';
}    

?>
