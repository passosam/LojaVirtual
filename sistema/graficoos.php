<?php
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include('phplot.php');
include ('conexao.php');
#Matriz utilizada para gerar os graficos

$cQry = "   SELECT COUNT(*) as TOT, ORS_STATUS
			FROM apl_ordemservico os 
			GROUP by ORS_STATUS  ";

$rsc = mysql_query( $cQry, $conexao );

$num = mysql_num_rows( $rsc );

$h_inicial = 0;	
$h_final = 0;
$diferenca = 0;
$total = 0;
$aux = '';
$i = 0;


while ( $ar = mysql_fetch_assoc( $rsc ))
{	
	if ($ar['ORS_STATUS'] == '')
	{
		$aux = 'Aberto';
	}
	else
	{
		$aux = 'Fechado';
	}
	$data[] = array($aux, $ar['TOT']);	
	
		
}



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
$plot->SetTitle('O.S. x Status');
#Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados

#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');

$plot->SetDataColors(array ('yellow')); 
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