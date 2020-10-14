<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";
	
	$usuario = new Usuario();
	$usuario->id_usuario = strip_tags(addslashes($_SESSION['id_usuario']));
	$usuario->status = strip_tags(addslashes($_POST['status']));
		
	$usuario->alterarStatus();
	echo $usuario->status;
?>