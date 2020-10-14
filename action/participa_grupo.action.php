<?php
	require_once '../class/grupo.class.php';
	require_once 'comuns.action.php';
	
	$grupo = new Grupo();
	$grupo->id_grupo = (int)$_GET['id_grupo'];
	$usuario = new Usuario;
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	if($usuario->participarGrupo($grupo)){
		header("location:../grupo.php?id_grupo=$grupo->id_grupo");
	}
?>