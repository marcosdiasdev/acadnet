<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>SocNet</title>
	<!-- Desabilita cache do IE -->
	<meta http-equiv='cache-control' content='no-cache' />
    <meta http-equiv='expires' content='0' />
    <meta http-equiv='pragma' content='no-cache' />
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="<?php echo $servidor;?>style/style.css"/>
	<script type='text/javascript' src='js/jquery-1.7.1.min.js'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
	<script type='text/javascript' src='js/jquery.elastic.source.js'></script>
</head>
<body>
<?php 
	require_once "action/comuns.action.php";
	
	if(isset($_SESSION['id_usuario'])){
?>
	<div id='container_editar_informacoes'></div>
	<div id='fundo'>
		<div id='subcontainer_editar_informacoes'></div>
	</div>
	<div id='container_criar_grupo'></div>
	
	<div id='container_topo'>
		<div id='subcontainer_topo'>
			<div id='container_navegacao'>
				<a id='home' href='<?php echo $servidor;?>home.php'>Início</a>
				<a id='sair' href='<?php echo $servidor;?>action/logout.action.php'>Sair</a>
			</div>
			<div id="container_logo">
				<h2 id="logo">Acadnet</h2>
			</div>
			<div id='container_busca'>
				<form method='post' action='busca.php'>
				   <input id='busca_campo' type='text' name='string_busca' />
				   <input id='busca_botao' type='submit' value='Buscar' />
				</form>
			</div>
		</div>
	</div>
	<div id='container_principal'>
		<div id='container_all'>
<?php 
	}else{
?>		
	<div id="login_container_topo">
		<form id="login" name="login" method="post" action="javascript:validaLogin()">
			<div id='login_container_email'>
				<label for='email_login' class="login_texto">E-mail:</label>
				<br />
				<input class="login_campo" type="text" name="email_login" id="email_login"/>
			</div>
			<div id='login_container_senha'>
				<label class="login_texto" for="senha_login">Senha:</label>
				<br />
				<input class="login_campo" id="senha_login" type="password" maxlength="16" name="senha_login"/>
				<br />
				<a href="esqueceu_a_senha.php">
					<span class="login_texto">Esqueceu a senha?</span>
				</a>
			</div>	
			<div id="login_container_entrar">
				<input id="login_botao_entrar" type="submit" value="Entrar"/>
			</div>
		</form>
	</div>

<div id='login_container_principal'>
	<div id='login_container_all'>
<?php
	}
?>		