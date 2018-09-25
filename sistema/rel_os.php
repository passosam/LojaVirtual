<?php

session_start();

require_once('tcpdf/config/lang/bra.php');
require_once('tcpdf/tcpdf.php');

include('conexao.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
     
    //Page header
    public function Header() {
       
        $image_file = K_PATH_IMAGES.'logo.png';
        
        $this->Image($image_file, 75, 10, 65, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        
        //--font
        $this->SetFont('helvetica', 'B', 16);
        
        //--titulo
        //$this->Cell( 135, 10, 'Mecasoft ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        $this->Cell( 1, 0, '', 0, 1 );
        $this->Cell( 1, 0, '', 0, 1 );
                        
        //--font
        $this->SetFont('helvetica', '', 12);
                
        //$this->Cell( 175 , 10, 'Mecânica JM', 0, false, 'C', 0, '', 0, false, 'M', 'M' );
        
        $this->Cell( 0, 0, '', 0, 1 );
			
        
        $this->Cell( 180, 10, 'SERVIÇOS, CONSULTORIA E COMÉRCIO DE PEÇAS E EQUIPAMENTOS MÉDICOS LTDA', 1, false, 'C', 0, '', 0, true, 'M', 'M'  );
                
        //--logo adv
        $image_file = K_PATH_IMAGES.'logo.png';
        //$this->Image($image_file, 170, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
       
        $this->Cell( 0, 0, '', 0, 1 );       
        //--font
        $this->SetFont('helvetica', '', 14);
                
        
        
    }

    // Page footer
    public function Footer() {
        
        $time = mktime(date('H')-2, date('i'), date('s')); 
        $hora = gmdate("H:i:s", $time);
        
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Page number
        $this->Cell( 189, 10,  'Gerado em '.date("d/m/Y").' às '.$hora.'                                                                                                  Página'.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        
        $this->SetY( -15 );
        $this->SetLineStyle( array( 'width' => 0.3, 'color' =>array( 0, 0, 0 ) ) );
        $this->Line( 195, 280 , 16, 280, 100, 100 );
    }
}

$id = $_GET['id'];

$cQry = " SELECT os.*,c.*, s.TPS_CODIGOTIPOSER, s.TPS_DESCRICAO, 
	                 e.*, u.USU_NOME
              FROM apl_ordemservico os
					INNER JOIN apl_cliente c
					ON os.cli_codigo = c.cli_codigo 
					INNER JOIN apl_tpservico s
					ON os.TPS_CODIGO = s.TPS_CODIGO	
					INNER JOIN apl_equipamento e
					ON os.EQP_CODIGO = e.EQP_CODIGO	
					INNER JOIN apl_usuario u
					ON os.USU_CODIGO = u.USU_CODIGO
			  WHERE os.ORS_CODIGO = '".$id."'		
              ORDER BY os.ORS_NUMERO ASC ";
    
$rsc = mysql_query( $cQry, $conexao );
$ar = mysql_fetch_assoc( $rsc );


$cQryCOM = "SELECT COM_HRFIM, COM_HRINI, COM_DATA FROM apl_complemento WHERE ORS_CODIGO = '".$id."'";
$rscCOM = mysql_query( $cQryCOM, $conexao );
$arCOM = mysql_fetch_assoc( $rscCOM );


//criando um novo arquivo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Relatório Ordem Serviço');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->setLanguageArray($l);

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, 'Mecanica JM' );

$pdf->SetFont('helvetica', '', 12);

$pdf->AddPage();

$pdf->setTextRenderingMode($stroke=0, $fill=true, $clip=false);
$html = '';

/*
if ( $nNum > 0 )
{   
	$cQry = "  SELECT c.*, cid.*
               FROM  cliente c
     			     inner join cidade cid on cid.CID_CODIGO = c.CID_CODIGO
			   WHERE c.CLI_CODIGO = ".$ar['CLI_CODIGO'];
			   
	$rscCid  = mysql_query ( $cQry, $conexao );
	$arCid  = mysql_fetch_array( $rscCid );
   
	$html  = '<br/><br/><br/><table width="100%" border="0" cellspacing="4">';  
	
	$html .= '  <tr>';
	$html .= '      <td colspan="2" align="left"><b>Dados da O.S.</b></td>';
	$html .= '      <td colspan="2" align="right"><b>N&uacute;mero Ordem Servi&ccedil;o:</b> '.$ar['ORS_CODIGO'].'</td>';

	$html .= '  </tr>';

	$html .= '  <tr>';
	$html .= '      <td colspan="4"><hr width="100%"></td>';
	$html .= '  </tr>';

	$html .= '  <tr>';
	$html .= '      <td align="right"><b>Data O.S.:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align=left>'.Stod( $ar['ORS_DTOS'] ).'</td>';
	$html .= '  </tr>';

	$html .= '  <tr>';
	$html .= '      <td align="right"><b>Nome do Cliente:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align="left" colspan="3">'.$ar['CLI_CODIGO'].' - '. trataTxt( $ar['CLI_NOME'] ).'</td>';
	$html .= '  </tr>';

	$html .= '  <tr>';
	$html .= '      <td align="right"><b>Endere&ccedil;o:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align="left" colspan="3">'.trataTxt( $ar['CLI_RUA'] ).'</td>';
	$html .= '  </tr>';

	$html .= '  <tr>';
	$html .= '      <td align="right"><b>Cidade:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td width="30%" align=left>'.trataTxt( $arCid['CID_DESCRICAO'] ).'</td>';
	$html .= '      <td align="right"><b>Cpf/Cnpj:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align=left>'.$ar['CLI_CNPJ'].'</td>';
	$html .= '  </tr>';

	$html .= '  <tr>';
	$html .= '      <td align="right"><b>Bairro:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align=left>'.trataTxt( $ar['CLI_BAIRRO'] ).'</td>';
	$html .= '      <td align="right"><b>CEP:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td width="35%" align=left>'.$ar['CLI_CEP'].'</td>';
	$html .= '  </tr>';    

	$html .= '  <tr>';
	$html .= '      <td align="right"><b>Mec&acirc;nico:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align=left>'.trataTxt( $ar['MEC_NOME'] ).'</td>';
	$html .= '      <td align="right"><b>Telefone:&nbsp;&nbsp;&nbsp;</b></td>';
	$html .= '      <td align=left>'.( empty( $ar['CLI_TELEFONE'] ) ? '' : $ar['CLI_TELEFONE'] ).'</td>';
	$html .= '  </tr>';    
	
	$html .= '  <tr>';
	$html .= '      <td align="right"></td>';
	$html .= '      <td align=left></td>';
	$html .= '      <td align="right"></td>';
	$html .= '      <td align=left></td>';
	$html .= '  </tr>';   

	$html .= '  <tr>';
	$html .= '      <td align="right"></td>';
	$html .= '      <td align=left></td>';
	$html .= '      <td align="right"></td>';
	$html .= '      <td align=left></td>';
	$html .= '  </tr>';  

	$html .= '</table>';

}

$html .= '<table width="100%" border="1">';

$html .= '<tr>';
$html .= '  <td width="10%" align="center"><b>Item O.S.</b></td>';
$html .= '  <td width="60%" align="center"><b>Produto/Servi&ccedil;o</b></td>';
$html .= '  <td width="20%" align="center"><b>Quantidade</b></td>';
$html .= '  <td width="10%" align="center"><b>Valor</b></td>';
$html1 = '</tr>';

$i = 0;

$cQry = " SELECT itos.*, p.POD_DESCRICAO, s.SER_DESCRICAO 
		  FROM itemos itos
			LEFT JOIN produto p ON itos.POD_CODIGO = p.POD_CODIGO
			LEFT JOIN servico s ON itos.SER_CODIGO = s.SER_CODIGO
		  WHERE ORS_CODIGO = ".$id;
				  
$rscItem = mysql_query( $cQry, $conexao );
				  
while ( $arItem = mysql_fetch_array( $rscItem ) )
{    

	$html1 .= '<tr>';
	$html1 .= '  <td align="center" width="10%">'.$arItem['ITE_CODIGO'].'</td>';
	$html1 .= '  <td align="center" width="60%">'.trataTxt(( $arItem['POD_DESCRICAO'] == '' ? $arItem['SER_DESCRICAO'] : $arItem['POD_DESCRICAO'] )).'</td>';
	$html1 .= '  <td width="20%" align="center">'.$arItem['ITE_QUANTIDADE'].'</td>';
	$html1 .= '  <td width="10%" align="right">'.number_format( $arItem['ITE_VALOR'], 2, ",", "." ).'</td>';
	$html1 .= '</tr>';
	
	$total += $arItem['ITE_VALOR'];
}

$html1 .= '<tr>';
$html1 .= '  <td width="10%" align="center"><b>Total</b></td>';
$html1 .= '  <td width="80%"></td>';
$html1 .= '  <td width="10%" align="right">'.number_format( $total, 2, ",", "." ).'</td>';   
$html1 .= '</tr>';

$html1 .= '</table>';
*/
// output the HTML content

$html  = '<br/><br/><br/><table width="95%" border="1"  cellspacing="0">';  
	
$html .= '  <tr>';
$html .= '      <td width="45%" VALIGN="MIDDLE" align="center"><b><font size="15">Ordem de Servi&ccedil;o</font></b></td>';
$html .= '      <td width="30%" align="center"><b>Chamado</b><br/>'.$ar['ORS_NUMERO'].'</td>';
$html .= '      <td width="20%" align="center"><b>Tipo Servi&ccedil;o</b><br/></td>';
$html .= '      <td width="10%" align="center"><b>CDC</b><br/></td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="65%" align="left"><b><font size="11">Cliente</font></b><br/>'.trataTxt($ar['CLI_NOME']).'</td>';
$html .= '      <td width="40%" align="left"><b><font size="11">P.E.P</font></b></td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="47%"  align="left"><b><font size="11">Endere&ccedil;o</font></b><br/>'.trataTxt($ar['CLI_ENDERECO']).'</td>';
$html .= '      <td width="30%" align="left"><b><font size="11">Cidade</font></b><br/>'.trataTxt($ar['CLI_CIDADE']).'</td>';
$html .= '      <td width="10%" align="center"><b><font size="11">UF</font></b><br/>'.$ar['CLI_UF'].'</td>';
$html .= '      <td width="18%" align="left"><b><font size="11">Telefone</font></b><br/>'.$ar['CLI_TELEFONE'].'</td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="35%"  align="left"><b><font size="11">Equipamento / Modelo</font></b><br/>'.trataTxt($ar['EQP_NOME']).'/'.trataTxt($ar['EQP_MODELO']).'</td>';
$html .= '      <td width="13%" align="center"><b><font size="11">S&eacute;rie</font></b><br/>'.trataTxt($ar['EQP_SERIE']).'</td>';
$html .= '      <td width="25%" align="center"><b><font size="11">SAP Equip.</font></b><br/></td>';
$html .= '      <td width="06%" align="center"><b><font size="11">Mont</font></b><br/><img src="image/img.png"/></td>';
$html .= '      <td width="06%" align="center"><b><font size="11">Gar</font></b><br/><img src="image/img.png"/></td>';
$html .= '      <td width="06%" align="center"><b><font size="11">Cont</font></b><br/><img src="image/img.png"/></td>';
$html .= '      <td width="06%" align="center"><b><font size="11">Serv</font></b><br/><img src="image/img.png"/></td>';
$html .= '      <td width="08%" align="center"><b><font size="11">Outros</font></b><br/><img src="image/img.png"/></td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="105%" align="left"><b><font size="11">Descri&ccedil;&atilde;o do Defeito</font></b></td>';
$html .= '  </tr>';

$defeito = $ar['ORS_DESCDEFEITO'];
$trans = get_html_translation_table (HTML_ENTITIES);
$string = htmlspecialchars_decode (strtr($defeito, $trans) );

$html .= '  <tr>';
$html .= '      <td width="105%" align="left"><font size="9">'.ucfirst(strtolower(trim(trataTxt($defeito)))).'</font></td>';
$html .= '  </tr>';		

$html .= '  <tr>';
$html .= '      <td width="105%" align="left"><b><font size="11">Servi&ccedil;o Executado</font></b></td>';
$html .= '  </tr>';

$i = 0;
$j = 0;


$string = $ar['ORS_SERVEXECUTADO'];
$trans = get_html_translation_table (HTML_ENTITIES);
$string = htmlspecialchars_decode (strtr($string, $trans) );
$aux = strlen($string);

while ( $i < $aux )
{	
	if ((substr($string,$i,1)) == '.')
	{
		$html .= '  <tr>';
		$html .= '      <td width="105%" align="left"><font size="9">'.ucfirst(strtolower(trim(trataTxt(substr($string,$j,$i+1-$j))))).'</font></td>';
		$html .= '  </tr>';		
		$j = $i+1;
	}
	$i++;
	
}

$html .= '  <tr>';
$html .= '      <td width="9%"  align="center"><b><font size="8">M&ecirc;s&nbsp;&nbsp;Ano</font></b><br/><font size="8"><u>'.substr($arCOM['COM_DATA'],5,2).'&nbsp;|&nbsp;'.substr($arCOM['COM_DATA'],2,2).'</u><br/><b>Dia</b></font></td>';
$html .= '      <td width="16%" align="center"><b><font size="8">Hor&aacute;rio</font></b><br/><font size="8">(HH:MM)<br/><b>Inicio | Final</b></font></td>';
$html .= '      <td width="16%" align="center"><b><font size="8">Hor&aacute;rio Comercial</font></b><br/><font size="8">(QTD)<br/><b>Normais | Viagem</b></font></td>';
$html .= '      <td width="15%" align="center"><b><font size="8">Horas Extras</font></b><br/><font size="8">(QTD)<br/><b>Servi&ccedil;o | Viagem</b></font></td>';
$html .= '      <td width="7%" align="center"><b><font size="8">Km</font></b><br/><font size="8">(QTD)</font></td>';
$html .= '      <td width="7%" align="center"><b><font size="8">Di&aacute;rias</font></b><br/><font size="8">(QTD)</font></td>';
$html .= '      <td width="35%" align="left"><b><font size="8">Obs.:</font></b><br/><font size="8"></font></td>';
$html .= '  </tr>';

$rscCOM = mysql_query( $cQryCOM, $conexao );

$i = 0; 
$horatotal = 0;

while ($arCOM = mysql_fetch_assoc( $rscCOM ))
{
	$horaNova = 0;	
	$h_inicial = strtotime($arCOM['COM_HRINI']) / 60;
	$h_final = strtotime($arCOM['COM_HRFIM']) / 60;
	$diferenca = $h_final - $h_inicial;
		
	
	$i++;	
	$horatotal = $horatotal + $diferenca;

	$html .= '  <tr>';
	$html .= '      <td width="9%"  align="center"><font size="8">'.substr( $arCOM['COM_DATA'],8,10).'</font></td>';
	$html .= '      <td width="8.1%" align="center"><font size="8">'.$arCOM['COM_HRINI'].'</font></td>';
	$html .= '      <td width="7.9%" align="center"><font size="8">'.$arCOM['COM_HRFIM'].'</font></td>';
	$html .= '      <td width="8.3%" align="center"><font size="8">'.mintohora($diferenca).'</font></td>';
	$html .= '      <td width="7.7%" align="center"><font size="8"></font></td>';
	$html .= '      <td width="7.5%" align="center"><font size="8"></font></td>';
	$html .= '      <td width="7.5%" align="left"><font size="8"></font></td>';
	
	if( $i == 1)
	{	
		$html .= '      <td width="49%" align="center"><b><font size="8">Pe&ccedil;as Utilizadas</font></b><br/><font size="8">Descri&ccedil;&atilde;o/Pedido&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp;C&oacute;digo</font></td>';
	}
	else
	{	
		$html .= '      <td width="29.2%" align="center"><font size="8"></font></td>';
		$html .= '      <td width="19.8%" align="center"><font size="8"></font></td>';	
	}
	$html .= '  </tr>';
}	

$html .= '  <tr>';
$html .= '      <td width="9%"  align="center"><font size="8">'.substr( $arCOM['COM_DATA'],8,10).'</font></td>';
$html .= '      <td width="8.1%" align="center"><font size="8"></font></td>';
$html .= '      <td width="7.9%" align="center"><font size="8"></font></td>';
$html .= '      <td width="8.3%" align="center"><font size="8"></font></td>';
$html .= '      <td width="7.7%" align="center"><font size="8"></font></td>';
$html .= '      <td width="7.5%" align="center"><font size="8"></font></td>';
$html .= '      <td width="7.5%" align="left"><font size="8"></font></td>';
$html .= '      <td width="29.2%" align="center"><font size="8"></font></td>';
$html .= '      <td width="19.8%" align="center"><font size="8"></font></td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="25%"  align="right"><font size="8"><b>Valores Totais</b></font></td>';
$html .= '      <td width="8.3%" align="center"><font size="8">'.mintohora($horatotal).'</font></td>';
$html .= '      <td width="7.7%" align="center"><font size="8"></font></td>';
$html .= '      <td width="7.5%" align="center"><font size="8"></font></td>';
$html .= '      <td width="7.5%" align="left"><font size="8"></font></td>';
$html .= '      <td width="29.2%" align="center"><font size="8"></font></td>';
$html .= '      <td width="19.8%" align="center"><font size="8"></font></td>';

$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="43%" align="left"><b><font size="9">T&eacute;nico / Engenheiro - Nome</font></b><br/>'.$ar['USU_NOME'].'</td>';
$html .= '      <td width="13%" align="center"><b><font size="9">Nº SAP TEC</font></b></td>';
$html .= '      <td width="49%" align="justify"><font size="6">
					<img src="image/q.png" width="225%"/>Declaramos que as horas e despesas acima discriminadas foram conferidas e est&atilde;o corretas.<br>
					&nbsp;<img src="image/q.png" width="225%"/>Declaramos que o equipamento se encontra em perfeito funcionamento.</font></td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="43%" align="left"><b><font size="9">T&eacute;nico / Engenheiro - Assinatura</font></b><br/></td>';
$html .= '      <td width="13%" align="center"><b><font size="9">Data</font></b><br/>__/__/____</td>';
$html .= '      <td width="49%" align="justify"><b><font size="6">&nbsp;&nbsp;&nbsp;_____/____/_______&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					______________________________________________</font></b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="8">Data &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Assinatura do Cliente</font></td>';
$html .= '  </tr>';

$html .= '  <tr>';
$html .= '      <td width="28%" align="center"><b><font size="9">Chefia T&eacute;nica - Visto/Data</font></b><br/></td>';
$html .= '      <td width="28%" align="center"><b><font size="9">Chefia Comercial - Visto/Data</font></b></td>';
$html .= '      <td width="49%" align="justify"><b><font size="6">&nbsp;&nbsp;&nbsp;____________________&nbsp;&nbsp;&nbsp;
					______________________________________________</font></b><br>&nbsp;<font size="8">Nº Doctº Identidade &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome Leg&iacute;vel</font></td>';
$html .= '  </tr>';

$html .= '</table>';        


$pdf->writeHTML( $html, true, 0, true, 0);

ob_start ();

//Close and output PDF document
$pdf->Output('Relatorio Ordem Serviço.pdf', 'I');

ob_end_flush (); 

   
function Stod( $cData ) { 
    $cRet = substr( $cData, 8, 10 )."/".substr( $cData, 5, 2 )."/".substr( $cData, 0, 4 ); 
    return $cRet;
}

function trataTxt($string, $slug = false) {
 
	//Setamos o localidade
    setlocale(LC_ALL, 'pt_BR');
 
    //Verificamos se a string é UTF-8
    if (is_utf8($string))
        $string = utf8_decode($string);
 
    //Se a flag 'slug' for verdadeira, transformamos o texto para lowercase
    if ($slug)
        $string = strtolower($string);
 
    // Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);
 
    // Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);
 
    //Fazemos um loop para criar as regras de troca dos caracteres acentuados
    foreach ($ascii as $key => $item) {
 
        $acentos = '';
        foreach ($item AS $codigo)
            $acentos .= chr($codigo);
        $troca[$key] = '/[' . $acentos . ']/i';
    }
 
    //Aplicamos o replace com expressao regular
    $string = preg_replace(array_values($troca), array_keys($troca), $string);
 
        //Se a flag 'slug' for verdadeira...
    if ($slug) {
 
        //Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
 
        //Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
     //   $string = trim($string, $slug);
    }
 
    return $string;
}

function is_utf8($string) {
 
    // From http://w3.org/International/questions/qa-forms-utf-8.html
    return preg_match('%^(?: [x09x0Ax0Dx20-x7E] # ASCII
    | [xC2-xDF][x80-xBF] # non-overlong 2-byte
    | xE0[xA0-xBF][x80-xBF] # excluding overlongs
    | [xE1-xECxEExEF][x80-xBF]{2} # straight 3-byte
    | xED[x80-x9F][x80-xBF] # excluding surrogates
    | xF0[x90-xBF][x80-xBF]{2} # planes 1-3
    | [xF1-xF3][x80-xBF]{3} # planes 4-15
    | xF4[x80-x8F][x80-xBF]{2} # plane 16
    )*$%xs', $string);
}
function mintohora($minutos)
{
	$hora = floor($minutos/60);
	$resto = $minutos%60;

	if (strlen($resto) == 1)
	{
		$resto = '0'.$resto; 
	} 
	return $hora.':'.$resto;
}
?>
