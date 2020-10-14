<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";

	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$usuario->nome = strip_tags(addslashes($_POST['nome']));
	$usuario->sobrenome = strip_tags(addslashes($_POST['sobrenome']));
	$usuario->nascimento = (int) $_POST['ano'] . '-' . (int) $_POST['mes'] . '-' . (int) $_POST['dia'];
	$usuario->email = strip_tags(addslashes($_POST['email']));
	$usuario->curso = strip_tags(addslashes($_POST['curso']));
	$usuario->instituicao = strip_tags(addslashes($_POST['instituicao']));
	$usuario->profissao = strip_tags(addslashes($_POST['profissao']));
	$usuario->empresa = strip_tags(addslashes($_POST['empresa']));
		
	$usuario->alterarInformacoes();
?>