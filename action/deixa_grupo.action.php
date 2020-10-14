<?php
	require_once '../class/grupo.class.php';
	require_once 'comuns.action.php';
	
	$grupo = new Grupo();
	$grupo->id_grupo = (int)$_GET['id_grupo'];
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	if($usuario->deixarGrupo($grupo)){
		header("location:../home.php");
	}
?>