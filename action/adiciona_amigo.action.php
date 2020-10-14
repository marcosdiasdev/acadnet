<?php
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';

	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$amigo = new Usuario();
	$amigo->id_usuario = (int)$_GET['id_amigo'];
	
	$usuario->adicionarAmigo($amigo);
?>