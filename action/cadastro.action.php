<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";
	
	$erro = '1';
	
	$usuario = new Usuario();
	$usuario->nome = strip_tags(addslashes($_POST['nome']));
	$usuario->sobrenome = strip_tags(addslashes($_POST['sobrenome']));
	$usuario->genero = (int)$_POST['genero'];
	$usuario->nascimento = (int) $_POST['ano'] . '-' . (int) $_POST['mes'] . '-' . (int) $_POST['dia'];
	$usuario->email = strip_tags(addslashes($_POST['email']));
	$usuario->senha = strip_tags(addslashes($_POST['senha']));
	
	if(Usuario::verificarEmail($usuario)){
		if($usuario->cadastrarUsuario()){
			$usuario->fazerLogin();
			$erro = '0';
		}else{
			$erro = '1';
		}
	}else{
		$erro = '2';
	}
	echo $erro;
	
	// Se $erro == 0; Cadastro realizado com sucesso;
	// Se $erro == 1; Problema no cadastro;
	// Se $erro == 2; Endereço de e-mail indisponível;
?>