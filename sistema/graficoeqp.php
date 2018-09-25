<?php
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include('phplot.php');
include ('conexao.php');
#Matriz utilizada para gerar os graficos

$cQry = "   SELECT COM_HRFIM, COM_HRINI, COM_DATA, os.ORS_CODIGO, concat(usu.EQP_NOME ,'-', usu.EQP_MODELO, ' ',usu.EQP_SERIE) as EQP
			FROM apl_complemento co
			INNER JOIN apl_ordemservico os ON co.ORS_CODIGO = os.ORS_CODIGO
			INNER JOIN apl_equipamento usu ON usu.EQP_CODIGO = os.EQP_CODIGO
			order by usu.EQP_CODIGO ASC ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );

$h_inicial = 0;	
$h_final = 0;
$diferenca = 0;
$horatotal = 0;
$aux = '';
$i = 0;


while ( $ar = mysql_fetch_assoc( $rsc ) )
{	
	
	if (($aux == $ar['EQP']) or ($aux == ''))
	{	
		$h_inicial = strtotime($ar['COM_HRINI']) / 60;
		$h_final = strtotime($ar['COM_HRFIM']) / 60;
		$diferenca = $h_final - $h_inicial;
		$horatotal = $horatotal + $diferenca;
	}
	else
	{
		$data [] = array($aux, mintohora($horatotal));	
		$h_inicial = 0;	
		$h_final = 0;
		$diferenca = 0;
		$horatotal = 0;
	}
	$aux = $ar['EQP'];		
}
$data [] = 	array($aux, mintohora($horatotal));

#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(800,600);
#Tipo de borda, consulte a documentacao
$plot->SetImageBorderType('plain');
#Tipo de grafico, nesse caso barras, existem diversos(pizza…)
$plot->SetPlotType('bars');
#Tipo de dados, nesse caso texto que esta no array
$plot->SetDataType('text-data');
#Setando os valores com os dados do array
$plot->SetDataValues($data);
#Titulo do grafico
$plot->SetTitle('Equipamentos x Horas Trabalhadas');
#Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados

#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');

$plot->SetDataColors(array ('red')); 
$plot->SetXTickPos('none');
#Gera o grafico na tela
$plot->DrawGraph();



function mintohora($minutos)
{
	$hora = floor($minutos/60);
	$resto = $minutos%60;

	if (strlen($resto) == 1)
	{
		$resto = '0'.$resto; 
	} 
	return $hora;
}
?>