<?php

session_start();

require_once('tcpdf/config/lang/bra.php');
require_once('tcpdf/tcpdf.php');

include('conexao.php');

$r = $_GET['r'];
$i = $_GET['i'];
$n = $_GET['n'];
$p = $_GET['p'];


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
     
    //Page header
    public function Header() {
       
        $image_file = K_PATH_IMAGES.'mecasoft.png';
        
        $this->Image($image_file, 10, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        //--font
        $this->SetFont('helvetica', 'B', 20);
        
        //--titulo
        $this->Cell( 135, 10, 'Central de Certidão', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        
        $this->Cell( 0, 0, '', 0, 1 );
		
		//--font
        $this->SetFont('helvetica', '', 18);
                
        $this->Cell( 175 , 10, ' Rua São Sebastião - Centro - Juiz de Fora MG ', 0, false, 'C', 0, '', 0, false, 'M', 'M' );
                      
               
        $this->Cell( 0, 0, '', 0, 1 );
              
               
        //--logo adv
        $image_file = K_PATH_IMAGES.'mecasoft.png';
        $this->Image($image_file, 170, 10, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
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
//criando um novo arquivo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Ficha Administrativa');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 15));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);


$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->setLanguageArray($l);


$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, 'Ficha Administrativa' );

$pdf->SetFont('helvetica', '', 18);

$pdf->setTextRenderingMode($stroke=0, $fill=true, $clip=false);

if ( $i == 'S' )
{
    //retorna os dados do servico
    $cQry2 = "SELECT s.SER_DESCRICAO
              FROM  movimentacao p
                 inner join itemovimentacao c
                 on p.MOV_CODIGO = c.MOV_CODIGO 
                 inner join servico s
                 on c.SER_CODIGO = s.SER_CODIGO
              WHERE p.MOV_NUMPEDIDO = '".$n."' ";

    $rsc2 = mysql_query( $cQry2, $conexao );
    
    $txtservico = "";
     
    while ( $ar2 = mysql_fetch_array( $rsc2 ))
    {
        $txtservico .= $ar2['SER_DESCRICAO'];  
        if ( !empty( $txtservico ))
        {
            $txtservico .= " / ";
        } 
    }       
    
    $pdf->AddPage();


    $html .= '<br><br><table width="100%" border="0">';
    
    $html .= '<tr>';
    $html .= '  <td width="100%" align="center"><b><u>Ficha Administrativa</u></b></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';

    $pdf->SetFont('helvetica', '', 14);
    $html .= '<tr>';
    $html .= '  <td width="25%" align="left"><b>Pedido N&uacute;mero:</b></td>';
    $html .= '  <td align="left">'.$n.'</td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';

    $cQry = "  SELECT p.*, c.CLI_NOME
               FROM  movimentacao p
                    inner join cliente c
                    on p.CLI_CODIGO = c.CLI_CODIGO
               WHERE p.MOV_NUMPEDIDO = '".$n."' ";

    $rsc = mysql_query( $cQry, $conexao );
    $ar = mysql_fetch_array( $rsc );

    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"><b>Cliente:</b></td>';
    $html .= '  <td align="left">'.trataTxt($ar['CLI_NOME']).'</td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';


    if ( $ar['CLI_SOLICITANTE'] == 'O MESMO' )
    {
        $solicitante = $ar['CLI_SOLICITANTE']; 
    }
    else
    {
        $cQry = "  SELECT p.*, c.CLI_NOME
                   FROM  movimentacao p
                    inner join cliente c
                    on p.CLI_SOLICITANTE = c.CLI_CODIGO 
                   WHERE p.MOV_NUMPEDIDO = '".$n."' ";

        $rsc = mysql_query( $cQry, $conexao );
        $ar = mysql_fetch_array( $rsc );

        $solicitante = $ar['CLI_NOME'];
    }

    $html .= '<tr>';
    $html .= '  <td width="25%" align="left"><b>Solicitante:</b></td>';
    $html .= '  <td align="left">'.trataTxt($solicitante).'</td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';

    

    $html .= '<tr>';
    $html .= '  <td width="25%" align="left"><b>Servi&ccedil;o:</b></td>';
    $html .= '  <td align="left">'.trataTxt( $txtservico ).'</td>';
    $html .= '</tr>';
    
    //dados da movimentacao
    $cQry = "  SELECT p.*
               FROM  movimentacao p
               WHERE p.MOV_NUMPEDIDO = '".$n."' ";

    $rsc = mysql_query( $cQry, $conexao );
    $ar = mysql_fetch_array( $rsc );

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%" align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%" align="left"><b>Pre&ccedil;o:</b></td>';
    $html1 .= '  <td align="left">'.number_format( $ar['MOV_VALOR'], 2, ",", ".").'</td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%" align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';


    $html1 .= '<tr>';
    $html1 .= '  <td width="25%" align="left"><b>Data Inicio:</b></td>';
    $html1 .= '  <td align="left">'.Stod($ar['MOV_DATA']).' </td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';


    list($dia, $mes, $ano) = explode('/', Stod($ar['MOV_DATA']));
    $time = mktime(0, 0, 0, $mes, $dia + $ar['MOV_PRAZOENTREGA'], $ano);
    $prazo = strftime('%d/%m/%Y', $time);

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%" align="left"><b>Data Entrega:</b></td>';
    $html1 .= '  <td align="left">'.$prazo.' </td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%" align="left"><b>Observa&ccedil;&atilde;o:</b></td>';
    $html1 .= '  <td align="left">'.trataTxt( $ar['MOV_OBSERVACAO'] ).'</td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="35%" align="left"><b>Visto de Autoriza&ccedil;&atilde;o/Data:</b></td>';
    $html1 .= '  <td align="left"> ________________________________</td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';

    $html1 .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';

    $result = mes_extenso(date('m'));


    $html1 .= '<tr>';
    $html1 .= '  <td width="100%" align="center"><b>Juiz de Fora: '.date('d').''.$result.''.date('Y').'</b></td>';
    $html1 .= '</tr>';

    $html1 .= '</table>';

    // output the HTML content
    $pdf->writeHTML( $html.$html1, true, 0, true, 0);
}
if ( $r == 'S' )
{
    //retorna os dados do servico
    $cQry2 = "SELECT s.SER_DESCRICAO, s.*
              FROM  movimentacao p
                 inner join itemovimentacao c
                 on p.MOV_CODIGO = c.MOV_CODIGO 
                 inner join servico s
                 on c.SER_CODIGO = s.SER_CODIGO
              WHERE p.MOV_NUMPEDIDO = '".$n."' ";

    $rsc2 = mysql_query( $cQry2, $conexao );
    
    $txtservico = "";
     
    while ( $ar2 = mysql_fetch_array( $rsc2 ))
    {
        $txtservico .= $ar2['SER_DESCRICAO'];  
        if ( !empty( $txtservico ))
        {
            $txtservico .= " / ";
        } 
    }   
    
    //retorna o valor recebido
    $cQryt = "SELECT p.TIT_VALOR
              FROM  titulos p
                  inner join movimentacao c
                  on p.MOV_CODIGO = c.MOV_CODIGO 
              WHERE c.MOV_NUMPEDIDO = '".$n."' AND TIT_PARCELA = 0 AND TIT_DTBAIXA IS NOT NULL ";

    $rsct = mysql_query( $cQry, $conexao );
    $art = mysql_fetch_array( $rsct );
    
    $entrada = number_format($art['TIT_VALOR'], 2, ",", ".");
    
    $pdf->AddPage();
        
    $html = '<br><br><table width="100%" border="0">';
    
    $html .= '<tr>';
    $html .= '  <td width="100%" align="center"><b><u>RECIBO</u></b></td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';
    
    $html .= '<tr>';
    $html .= '  <td width="25%"  align="left"></td>';
    $html .= '  <td align="left"></td>';
    $html .= '</tr>';
    
    $cQry = "  SELECT p.*, c.*, e.CON_DESCRICAO, f.FOP_DESCRICAO
               FROM  movimentacao p
                    inner join cliente c
                    on p.CLI_CODIGO = c.CLI_CODIGO
                    inner join condicaopagamento e
                    on p.CON_CODIGO = e.CON_CODIGO
				    inner join formapag f
				    on f.FOP_CODIGO = p.FOP_CODIGO
               WHERE p.MOV_NUMPEDIDO = '".$n."' ";

    $rsc = mysql_query( $cQry, $conexao );
    $ar = mysql_fetch_array( $rsc );
    
    if ( $ar['CLI_SOLICITANTE'] == 'O MESMO' )
    {
        $solicitante = $ar['CLI_NOME']; 
        $nacionalidade = $ar['CLI_NACIONALIDADE'];
        $estadocivil = $ar['CLI_ESTADOCIVIL'];
        $profissao = $ar['CLI_PROFISSAO'];
        $rg = $ar['CLI_RG'];
        $endereco = $ar['CLI_ENDERECO'];
        $bairro = $ar['CLI_BAIRRO'];
        $complemento = $ar['CLI_COMPLEMENTO'];
		$dtexpedicao = $ar['CLI_DTEXPEDICAO'];
		$emissor = $ar['CLI_EMISSOR'];
		$cep  = $ar['CLI_CEP'];		
		$condicao = $ar['CON_DESCRICAO'];
		
    }
    else
    {
        $cQry = "SELECT p.*, c.*, e.CON_DESCRICAO, f.FOP_DESCRICAO
                 FROM  movimentacao p
                        inner join cliente c
                        on p.CLI_SOLICITANTE = c.CLI_CODIGO 
						inner join condicaopagamento e
                        on p.CON_CODIGO = e.CON_CODIGO
						inner join formapag f
				        on f.FOP_CODIGO = p.FOP_CODIGO
                 WHERE p.MOV_NUMPEDIDO = '".$n."' ";

        $rsc1 = mysql_query( $cQry, $conexao );
        $ar1 = mysql_fetch_array( $rsc1 );

        $solicitante = $ar1['CLI_NOME'];
        $nacionalidade = $ar1['CLI_NACIONALIDADE'];
        $estadocivil = $ar1['CLI_ESTADOCIVIL'];
        $profissao = $ar1['CLI_PROFISSAO'];
        $rg = $ar1['CLI_RG'];
        $endereco = $ar1['CLI_ENDERECO'];
        $bairro = $ar['CLI_BAIRRO'];
        $complemento = $ar['CLI_COMPLEMENTO'];
		$dtexpedicao = $ar['CLI_DTEXPEDICAO'];
		$emissor = $ar['CLI_EMISSOR'];
		$cep  = $ar['CLI_CEP'];
		$fop = $ar['FOP_DESCRICAO'];
		$condicao = $ar['CON_DESCRICAO'];
    }
    
    $resto = $ar['MOV_VALOR'] - $entrada;

    $html .= '<tr>';
    $html .= '  <td width="100%"  align="justify">DECLARO RECEBER NESTE ATO do(a) CONTRATANTE '.trataTxt(strtoupper($solicitante)).', '.trataTxt(strtoupper($nacionalidade)).', '.trataTxt(strtoupper($estadocivil)).', '.trataTxt(strtoupper($profissao)).', PORTADOR(A) DA CARTEIRA DE IDENTIDADE N&ordm; '.$rg.', , EXPEDIDA PELA '.Stod(strtoupper($emissor)).', EM '.Stod($dtexpedicao).', RESIDENTE E DOMICILIADA NA 
                '.trataTxt(strtoupper($endereco)).', '.trataTxt(strtoupper($bairro)).', '.trataTxt(strtoupper($complemento)).', CEP.: '.$cep.', SENDO PAGO NESTE ATO OS HONOR&Aacute;RIOS CONTRATADOS NO VALOR TOTAL DE R$'.number_format($ar['MOV_VALOR'], 2, ",",".").' ('.valorPorExtenso($ar['MOV_VALOR'], true).'), PAGOS EM '. trataTxt(strtoupper($condicao)).', '.trataTxt(strtoupper($fop)).', COM A FINALIDADE ESPECIFICA DE SOLICITAR a '.trataTxt(strtoupper($txtservico)).' de '.trataTxt(strtoupper($ar['CLI_NOME'])).', NASCIMENTO OCORRIDO EM '.Stod($ar['CLI_DTNASCTO']).'</td>';
    
    $html .= '</tr>';
    
    $html1  = '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';
    
    $html1  = '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';

    $html1  .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';
    $result = mes_extenso(date('m'));


    $html1 .= '<tr>';
    $html1 .= '  <td width="100%" align="center"><b>Juiz de Fora: '.date('d').''.$result.''.date('Y').'</b></td>';
    $html1 .= '</tr>';
    
    $html1  .= '<tr>';
    $html1 .= '  <td width="25%"  align="left"></td>';
    $html1 .= '  <td align="left"></td>';
    $html1 .= '</tr>';
    
    $html1 .= '<tr>';
    $html1 .= '  <td width="100%" align="center"><b>__________________________________________</b></td>';
    $html1 .= '</tr>';
    
    $html1 .= '<tr>';
    $html1 .= '  <td width="100%" align="center"><b>'.$_SESSION['ss_nome'].'</b></td>';
    $html1 .= '</tr>';
    
    $html .= '</table>';

    // output the HTML content
    $pdf->writeHTML( $html.$html1, true, 0, true, 0);


}



ob_start ();

//Close and output PDF document
$pdf->Output('imprime.pdf', 'I');

ob_end_flush (); 

function Stod( $cData ) { 
    $cRet = substr( $cData, 8, 10 )."/".substr( $cData, 5, 2 )."/".substr( $cData, 0, 4 ); 
    return $cRet;
}

function trataTxt($string) {
 
	$array1 = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
        $array2 = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
        $string = str_replace( $array1, $array2, $string); 
	
	return utf8_encode($string); //finaliza, gerando uma saída para a funcao
} 

function mes_extenso($referencia = NULL){
    switch ($referencia){
    case 1: $mes = " de Janeiro de "; break;
    case 2: $mes = " de Fevereiro de "; break;
    case 3: $mes = " de Março de "; break;
    case 4: $mes = " de Abril de "; break;
    case 5: $mes = " de Maio de "; break;
    case 6: $mes = " de Junho de "; break;
    case 7: $mes = " de Julho de "; break;
    case 8: $mes = " de Agosto de "; break;
    case 9: $mes = " de Setembro de "; break;
    case 10: $mes = " de Outubro de "; break;
    case 11: $mes = " de Novembro de "; break;
    case 12: $mes = " de Dezembro de "; break;
    default: $mes = " de _______________ de ";
    }
    return $mes;
}



function valorPorExtenso($valor=0, $complemento=true) {
    $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
     
    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
     
    $z=0;
     
    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for($i=0;$i<count($inteiro);$i++)
    for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
    $inteiro[$i] = "0".$inteiro[$i];
     
    // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
    $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
    for ($i=0;$i<count($inteiro);$i++) {
    $valor = $inteiro[$i];
    $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
    $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
    $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
    $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
    $t = count($inteiro)-1-$i;
    if ($complemento == true) {
    $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
    if ($valor == "000")$z++; elseif ($z > 0) $z--;
    if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
    }
    if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }
     
    return($rt ? $rt : "zero");
}
 
?>
