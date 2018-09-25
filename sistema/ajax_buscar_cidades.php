<?php
include('conexao.php');
$estado = $_GET['CLIENTE'];
$sql = "SELECT e.*
		FROM apl_equipamento e
		WHERE CLI_CODIGO = $estado ";
$res = mysql_query($sql, $conexao);
$num = mysql_num_rows($res);
for ($i = 0; $i < $num; $i++) {
  $dados = mysql_fetch_array($res);
  $arrCidades[$dados['EQP_CODIGO']] = utf8_encode($dados['EQP_NOME'].'-'.$dados['EQP_SERIE']);
}
?>

<select name="EQP" id="EQP"  class="form-control7">
  <?php foreach($arrCidades as $value => $nome){
    echo "<option value='{$value}'>{$nome}</option>";
  }
?>
</select>
