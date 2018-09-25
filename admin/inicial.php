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
    $inicio = 20 * ( $pagina - 1 ) ;

    $maximo = 20 ;
    
// selecionando os usuários por nome e ordenando
    $cQry = " SELECT * 
              FROM inicial
              ORDER BY INI_COD DESC ";
    $cQry .= 'LIMIT '.$inicio.', '.$maximo.' ';

    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     
    echo '<table width=700 align=center border=0>';
    
    echo '<thead>';
    
    echo '  <tr>';
    echo '      <td colspan="3" class=CorContato>Inicial</td>';
    echo '  </tr>';
        
    echo '  <tr>';
    echo '      <td colspan="3" align="center"><b><a href=index.php?url=inicial&do=new class="menn">Adicionar | </a><a href="index.php?url=inicial" class="menn">Listar</a></b><br><br></td>';
    echo '  </tr>';

    if ( $num > 0 )
    {
        
        echo '  <tr>';
        echo '      <td class="TitleCol1" colspan=3><form method="post" action="exemplo.html" class="form" id="frm-filtro">';
        echo '          <p>';
        echo '              <label for="pesquisar">Pesquisar</label>';
        echo '              <input type="text" id="pesquisar" name="pesquisar" class="campo" size="50" />';
        echo '          </p>';
        echo '          </form></td>';
        echo '  </tr>';

        echo '  <tr>';
        echo '      <td class="TitleCol">Imagem</td>';
        echo '      <td class="TitleCol">Frase</td>';
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
                echo '<tr bgcolor="#cccccc">';
            }
            
            echo '      <td width=500 class="TitleRow"><img src="../images/home/'.$ar['INI_IMAGEM'].'" width=30% border=0></td>';
            echo '      <td width=450 class="TitleRow">'.stripcslashes( $ar['INI_FRASE'] ).'</td>';
            echo '      <td width=100 align=center><a href="index.php?url=inicial&do=del&id='.$ar['INI_COD'].'"><img src=../images/excluir.png border="0"></a>
												   <a href="index.php?url=inicial&do=edit&id='.$ar['INI_COD'].'"><img src=../images/editar.png border="0"></a>';
            echo '      </td>';
            echo '  </tr>';
            
            $bZeb = !$bZeb; 
        }
        
        echo '  </tbody>';
    }    
    
    $menos = $pagina - 1 ;

    $cQry = " SELECT *
              FROM inicial ";
        
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
            echo '<a href="index.php?url=inicial&pagina='.$menos.'" class="pag">anterior</a>&nbsp; '; 
        }   
        
        for($i=1;$i <= $pgs;$i++) 
        { 
            if($i != $pagina) 
            { 
                echo '<a href="index.php?url=inicial&pagina='.($i).'" class="pag">'.$i.'</a> | '; 
            } 
            else 
            { 
                echo ' <strong><b class="pag">'.$i.'</b></strong> | '; 
            } 
        }   
        if($mais <= $pgs) 
        { 
            echo ' <a href="index.php?url=inicial&pagina='.$mais.'" class="pag">pr&oacute;xima</a>'; 
        } 
    } 

    
    echo '</td></tr>';

    echo '</table>';
}
else
{  
    $cFrase  = '';
	$cImagem = '';
    $disabled = "";
    $cBotao = "Cadastrar";
    
    if ( $do == "edit" || $do == "del" )
    {
        $cBotao = "Alterar";
        $id = $_GET['id'];
        
        $cQry = " SELECT * 
                  FROM inicial
                  WHERE INI_COD = ".$id ;
        
        
        $rsc = mysql_query( $cQry, $conexao );

        $ar = mysql_fetch_assoc($rsc);
        
        $cFrase   = stripcslashes($ar['INI_FRASE']);       
        $cImagem = $ar['INI_IMAGEM'];
		
        if ( $do == "del" )
        {
            $cBotao = "Excluir";
            $disabled = "disabled";
        }
        
        echo '<form method="post" action="gravarbanco.php?url=inicial&do='.$do.'&id='.$id.'" id="frmCad" name="frmCad" enctype="multipart/form-data">';

    }
    elseif ( $do == "new" )
    {
        echo '<form method="post" action="gravarbanco.php?url=inicial&do='.$do.'" id="frmCad" name="frmCad" enctype="multipart/form-data">';
    }
   
    echo '<table width=500 align=center border=0>';

    echo '  <tr>';
    echo '      <td colspan="2" class=CorContato>'.$cBotao.' Inicial</td>';
    echo '  </tr>';
    
    echo '  <tr>';
    echo '      <td colspan="2" align=center><a href=index.php?url=inicial class="menn">Listar</a><br><br></td>';
    echo '  </tr>';

    echo '  <tr>';
    echo '      <td class="CorLinha">Frase:</td>';
    echo '      <td><textarea name="INI_FRASE" id="INI_FRASE" rows = "05" cols = "67" '.$disabled.' title="Frase" class="campo">'.str_replace("<br />", "",stripcslashes($cFrase)).'</textarea></td>';
    echo '  </tr>';
	
    echo '  <tr>';
    echo '      <td class="CorLinha">Imagem:</td>';
    echo '      <td><input type="file" name="INI_IMAGEM" id="INI_IMAGEM" title="Imagem" class="campo"></td>';
    echo '  </tr>';	
	
	if ( $do == "edit" && !empty( $cImagem ) )
	{
		echo '  <tr>';
		echo '      <td  class="CorLinha">Manter Imagem Atual?</td>';
		echo '      <td><input type="checkbox" name="OP" id="OP" value="1" '.$disabled.' checked class="campo"></td>';
		echo '  </tr>';
	}

    echo '  <tr>';
    echo '      <td colspan="2" align=center><input type="submit" value="'.$cBotao.'" name="botao" id="botao" class="submit"></td>';
    echo '  </tr>';

    echo '</table>';

    echo '</form>';
}    

?>
