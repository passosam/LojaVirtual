<?php
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include('phplot.php');
include ('conexao.php');
#Matriz utilizada para gerar os graficos

$cQry = " SELECT COM_HRFIM, COM_HRINI, COM_DATA, os.ORS_CODIGO, usu.USU_LOGIN 
			  FROM apl_complemento co
					inner join apl_ordemservico os on
					 co.ORS_CODIGO = os.ORS_CODIGO
					inner join apl_usuario usu on
					 usu.USU_CODIGO = os.USU_CODIGO ";

$cQry .= " ORDER BY usu.USU_LOGIN ";

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
	
	if (($aux == $ar['USU_LOGIN']) or ($aux == ''))
	{	
		$h_inicial = strtotime($ar['COM_HRINI']) / 60;
		$h_final = strtotime($ar['COM_HRFIM']) / 60;
		$diferenca = $h_final - $h_inicial;
		$horatotal = $horatotal + $diferenca;
	}
	else
	{
		$data []= array($aux, mintohora($horatotal));	
		$h_inicial = 0;	
		$h_final = 0;
		$diferenca = 0;
		$horatotal = 0;
	}
	$aux = $ar['USU_LOGIN'];		
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
$plot->SetTitle('Tecnico x Horas Trabalhadas');
#Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados

#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos('none');
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