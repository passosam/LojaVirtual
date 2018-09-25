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
			
        
        //$this->Cell( 180, 10, 'SERVIÇOS, CONSULTORIA E COMÉRCIO DE PEÇAS E EQUIPAMENTOS MÉDICOS LTDA', 1, false, 'C', 0, '', 0, true, 'M', 'M'  );
                
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

$cliente = $_GET['cli'];
$eqp = $_GET['eqp'];

$cQry = " SELECT os.*,c.CLI_NOME,
	                 e.EQP_NOME, e.EQP_MODELO, u.USU_NOME
              FROM apl_ordemservico os
					left JOIN apl_cliente c
					ON os.cli_codigo = c.cli_codigo 
					left JOIN apl_equipamento e
					ON os.EQP_CODIGO = e.EQP_CODIGO	
					left JOIN apl_usuario u
					ON os.USU_CODIGO = u.USU_CODIGO
			  	";
			  
	if (!empty($cliente))
	{
		$cQry .= "WHERE os.CLI_CODIGO = '".$cliente."' ";	
	}
	
	if (!empty($eqp))
	{
		$cQry .= " AND os.EQP_CODIGO = '".$eqp."'  ";	
	}	

	
			  
    $cQry .= "ORDER BY os.ORS_NUMERO ASC ";
    echo $cQry;
    $rsc = mysql_query( $cQry, $conexao );

    $num = mysql_num_rows( $rsc );
     	
    if ( $num > 0 )
    {
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
		
		
		$html  = '<br/><br/><br/><table width="100%" border="1"  cellspacing="0">';  
			
		$html .= '  <tr>';
		$html .= '      <td VALIGN="MIDDLE" cellspacing="5" colspan="4" align="center"><b><font size="14">Relat&oacute;rio de Ordem de Servi&ccedil;o</font></b></td>';
		$html .= '  </tr>';
		
		$html .= '  <tr>';
		$html .= '      <td width="15%" align="center"><b><font size="10">O.S.</font></b></td>';
		$html .= '      <td width="45%"><b><font size="10">Cliente</font></b></td>';
		$html .= '      <td width="13%"><b><font size="10">T&eacute;cnico</font></b></td>';
		$html .= '      <td width="13%" align="center"><b><font size="10">Data</font></b></td>';
		$html .= '      <td width="14%" align="center"><b><font size="10">Hora Trabalhada</font></b></td>';
		$html .= '  </tr>';
		
		
		while ( $ar = mysql_fetch_assoc( $rsc ) )
        {	
			$h_inicial = 0;
			$h_final = 0;
			$diferenca = 0;
			$horatotal = 0;
			
			$cQryCOM = "SELECT COM_HRFIM, COM_HRINI, COM_DATA FROM apl_complemento WHERE ORS_CODIGO = '".$ar['ORS_CODIGO']."'";
			$rscCOM = mysql_query( $cQryCOM, $conexao );
			$arCOM = mysql_fetch_assoc( $rscCOM );
			
			while ($arCOM = mysql_fetch_assoc( $rscCOM ))
			{
				$horaNova = 0;	
				$h_inicial = strtotime($arCOM['COM_HRINI']) / 60;
				$h_final = strtotime($arCOM['COM_HRFIM']) / 60;
				$diferenca = $h_final - $h_inicial;
				$horatotal = $horatotal + $diferenca;
			}
			
			$html .= '  <tr>';
			$html .= '  	<td cellspacing="3" align="center" width="15%"><font size="10">'.$ar['ORS_NUMERO'].'</font></td>';			
			$html .= '  	<td cellspacing="3" width="45%"><font size="10">'.trataTxt($ar['CLI_NOME']).'</font></td>';			
			$html .= '  	<td><font size="10">'.trataTxt($ar['USU_NOME']).'</font></td>';
			$html .= '  	<td align="center"><font size="10">'.Stod($ar['ORS_DTINICIO']).'</font></td>';
			$html .= '      <td align="center"><font size="8">'.mintohora($horatotal).'</font></td>';
	
			$html .= ' </tr>'; 
		}
		
		
		$html .= '</table>';        


		$pdf->writeHTML( $html, true, 0, true, 0);

		ob_start ();

		//Close and output PDF document
		$pdf->Output('Relatorio.pdf', 'I');

		ob_end_flush (); 


	}
		   
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
