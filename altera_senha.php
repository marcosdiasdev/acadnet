<?php
	include 'class/usuario.class.php';
	include 'action/comuns.action.php';
	
	$codigo = strip_tags(addslashes($_GET['codigo']));
	$email = strip_tags(addslashes($_GET['email']));
	include 'header.php'
?>
		<form method='post' action='javascript:validaAlteraSenha()'>
			<input type='hidden' value='<?php echo $codigo; ?>' name='codigo' />
			<input type='hidden' value='<?php echo $email; ?>' name='email' />
			Nova senha:
			<br /> 
			<input type='password' name='senha1'/>
			<br />
			Redigite a senha:
			<br />
			<input type='password' name='senha2'/>
			<br />
			<input type='submit' value='Enviar'/>
		</form>
<?php include 'footer.php'?>