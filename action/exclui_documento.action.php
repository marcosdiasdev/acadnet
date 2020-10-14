<?php
	require_once '../class/usuario.class.php';
	require_once '../class/documento.class.php';
	require_once 'comuns.action.php';
	include '../header.php';
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
		exit;
	}
	
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$documento = new Documento();
	$documento->id_documento = (int)$_GET['id'];
	
	if($usuario->excluirDocumento($documento)){
		header("location:../documentos.php?id=$usuario->id_usuario");
	} else {
		echo "Alguma coisa não saiu como esperávamos. Tente novamente.".
		"<a class='menu_usuario_topico' href='../documentos.php?id=$usuario->id_usuario'>Voltar</a>";
	}
	include '../footer.php';
?>