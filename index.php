<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>SocNet</title>	
	<!-- Desabilita cache do IE -->
	<meta http-equiv='cache-control' content='no-cache' />
    <meta http-equiv='expires' content='0' />
    <meta http-equiv='pragma' content='no-cache' />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style/style.css"/>
	<script type='text/javascript' src='js/jquery-1.7.1.min.js'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
</head>
<body>
<?php
	require_once "action/comuns.action.php";
	include "header.php";
	
	if(isset($_SESSION['id_usuario'])){
		header('location:home.php');
	}
?>
		<div id='login_container_up'>
			<div id='login_subcontainer_up'>
			</div>
		</div>

		<div id='login_container_left'>
<?php
$imagens = array('bg_apresentacao1.jpg', 'bg_apresentacao2.jpg','bg_apresentacao3.jpg');
$bg = $imagens[rand(0, count($imagens) -1)];
?>

			<div id='login_subcontainer_left' style="background:url('imagem/<?php echo $bg;?>') no-repeat;">
			
				<div id='subcontainer_left_texto'>
				
					<span id='texto_apresentacao'>
						<b>Bem-vindo à Acadnet</b>.
						<br />
						Comece agora mesmo a compartilhar conhecimento.
					</span>
			
				</div>
			</div>
		</div>

		<div id='login_container_right'>
			<div id='login_subcontainer_right'>
		
				<form name='cadastro' id="cadastro" action="javascript:validaCadastro()"  method="post">	
				
					<label id='nome_cadastro' for='nome'  class="cadastro_texto">
						Nome:
					</label>
					
					<br />
					
					<input class="cadastro_campo" type="text" name="nome" maxlength="45"/>
					
					<br />
					
					<label id='sobrenome_cadastro' for='sobrenome'  class="cadastro_texto">
						Sobrenome:
					</label>
					
					<br />
					
					<input class="cadastro_campo" type="text" name="sobrenome" maxlength="45"/>
					
					<br/>
				
					<label  id='genero_cadastro' for='genero'  class="cadastro_texto">
						Gênero:
					</label>
					
					<br />
					
					<select id="campo_genero" name="genero">
						<option value="" selected="selected">Selecione o gênero:</option>
						<option value="1">Masculino</option>
						<option value="2">Feminino</option>
					</select>
					
					<br />
					
					<label id='nascimento_cadastro' for='nascimento' class="cadastro_texto">
						Nascimento:
					</label>
					
					<br />

					<select id="campo_dia" name="dia">
						<option value="" selected="selected">Dia:</option>
						<?php
							$dia = 1;
							while($dia < 32){
								echo "<option value='" . $dia . "'>" . $dia . "</option>";
								$dia++;
							}
						?>
					</select>
									
					<select id="campo_mes" name="mes">
						<option value="" selected="selected">Mês</option>
						<option value="01">Janeiro</option>
						<option value="02">Fevereiro</option>
						<option value="03">Março</option>
						<option value="04">Abril</option>
						<option value="05">Maio</option>
						<option value="06">Junho</option>
						<option value="07">Julho</option>
						<option value="08">Agosto</option>
						<option value="09">Setembro</option>
						<option value="10">Outubro</option>
						<option value="11">Novembro</option>
						<option value="12">Dezembro</option>
					</select>
					
					<select id="campo_ano" name="ano">
						<option value="" selected="selected">Ano</option>
						<?php
							$ano = date("Y");
							while($ano > 1900){
								echo "<option value='" . $ano . "'>" . $ano . "</option>";
								$ano--;
							}
						?>
					</select>	
					<br />
					<label id='email_cadastro' for='email'  class="cadastro_texto">E-mail:</label>
					<br />
					<input class="cadastro_campo" type="text" name="email" maxlength="254" />
					<br />
					<label id='senha_cadastro' for='senha'  class="cadastro_texto">Senha:</label>
					<br />
					<input class="cadastro_campo" type="password" maxlength="16"  name="senha" maxlength="254" />
					<br />
					<br />
					<input id="cadastro_botao" type="submit" value="Cadastre-se" />
				</form>
			</div>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>