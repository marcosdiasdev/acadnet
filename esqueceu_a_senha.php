<?php
	require_once 'class/usuario.class.php';
	require_once 'action/comuns.action.php';
	include 'header.php';
?>	
		Para redefinir sua senha, digite o endereço de e-mail que você usa para entrar na Acadnet. 
		<br /><br />
		<form method='post' action='javascript:enviaEmailAlteraSenha()'>
			E-mail: 
			<input type='text' name='email'/>
			<input type='submit' id='enviar' value='Enviar'/>
		</form>
<?php 
	include 'footer.php';
?>