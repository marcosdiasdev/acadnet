<?php
	include 'class/usuario.class.php';
	include 'action/comuns.action.php';
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
		exit;
	}
	
	$id_usuario = $_SESSION['id_usuario'];
	
	include 'header.php'
?>
		<span>Você deseja mesmo excluir sua conta? Seus dados serão apagados definitivamente.</span>
		<form method='post' action='javascript:excluirConta();'>
			Digite sua senha:
			<br />
			<input type='password' name='senha'/>
			<br />
			<input id='enviar' type='submit' value='Enviar'/>
		</form>
<?php include 'footer.php'?>