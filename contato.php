<script type="text/javascript">
function limpa(i)
{
	document.getElementById(i).value="";
	document.getElementById(i).focus();
	document.getElementById(i).style.color = "black";
}
</script>

<script src="js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function()
   {
      $("#frmContato").validate({
         rules: {
            COT_NOME:   { required: true },
            CON_INFORMACAO:  { required: true }
         },
         messages: {
            COT_NOME:   { required: '<br><b class="Mensagem">Informe seu nome</b>'   },
            COT_INFORMACAO: { required: '<br><b class="Mensagem">Informe sua mensagem</b>' }
         }
      });
   });
</script>

<?php

include('conexao.php');

$cNome      = "Nome";
$cEmail     = "E-mail";
$cAssunto   = "Assunto";
$cInformacao = "Escreva sua mensagem";
$disabled   = "";


echo '<div id="cab13">
		<img src="image/contato/mensagem.png" border="0">
	  </div>';

echo '<div id="cab14">CONTATO			
	  </div>';

echo '<form method="post" action=admin/gravarbanco.php?url=contato	id="frmContato" name="frmContato">';
    	  
	  
echo '<table border="0"  cellspacing="4" width=70% align="left">';


echo '  <tr>';
echo '      <td><div id="tam1">
					<div id="field3"><input type="text" name="COT_NOME" id="COT_NOME" '.$disabled.' value="'.$cNome.'" onfocus="limpa(\'COT_NOME\');" size="57"></div>
				</div>
			</td>';
echo '  </tr>';

echo '  <tr>';
echo '      <td><div id="tam1">
					<div id="field3"><input type="text" name="COT_EMAIL" id="COT_EMAIL" '.$disabled.' value="'.$cEmail.'" onfocus="limpa(\'COT_EMAIL\');" size="57"></div>
				</div>
			</td>';
echo '  </tr>';

echo '  <tr>';
echo '      <td><div id="tam1">
					<div id="field5"><select name="COT_ASSUNTO" id="COT_ASSUNTO" onfocus="limpa(\'COT_ASSUNTO\');">
										<option value="">Assunto</option>
										<option value="Dúvida">D&uacute;vidas</option>
										<option value="Sugestão">Sugest&otilde;es</option>
										<option value="Orçamento">Or&ccedil;amentos</option>
									 </select>
					</div>
				</div>
			</td>';
echo '  </tr>';

echo '  <tr>';
echo '      <td><div id="tam1">
					<div id="field4"><textarea id="COT_INFORMACAO" name="COT_INFORMACAO" value="'.$cInformacao.'" onfocus="limpa(\'COT_INFORMACAO\');" '.$disabled.'  id="COT_INFORMACAO">'.$cInformacao.'</textarea></div>
				</div>
			</td>';
echo '  </tr>';

echo '  <tr>';
echo '      <td align=center>
				<div id="tam1">
					<input type="submit" value="Enviar" name="botao" id="botao" class="botaoenvia">
				</div>
			</td>';
echo '  </tr>';

echo '</table>'; 

echo '</form>';

?>

