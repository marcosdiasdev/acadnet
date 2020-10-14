<?php
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:../index.php');
		exit;
	}
	
	$usuario = new Usuario();
	$usuario->id_usuario=$_SESSION['id_usuario'];
	$usuario->senha = $_POST['senha'];
	
	if($usuario->excluirConta()){
		echo true;
	}else{
		echo false;
	}
?>