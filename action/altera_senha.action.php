<?php
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';
	
	$usuario = new Usuario();
	$usuario->codigo_redefinicao_senha = strip_tags(addslashes($_POST['codigo']));
	$usuario->email = strip_tags(addslashes($_POST['email']));
	$usuario->senha	= strip_tags(addslashes($_POST['senha1']));
		
	if($usuario->alterarSenha()){
		echo true;
	}else{
		echo false;
	}
?>