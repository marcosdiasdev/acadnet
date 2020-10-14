<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";
	
	$usuario = new Usuario();
	$usuario->email = strip_tags(addslashes($_POST['email_login']));
	$usuario->senha = strip_tags(addslashes($_POST['senha_login']));
	
	if($usuario->fazerLogin()){
		echo false;
	}else{
		echo true;
	}
?>