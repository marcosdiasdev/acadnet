<?php
	require_once '../class/topico.class.php';
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';

	$topico = new Topico();
	$topico->id_topico = (int)$_GET['id_topico'];
	$topico->grupo_id_grupo = (int)$_GET['id_grupo'];
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	if($usuario->excluirTopico($topico)){
		header("location:../grupo.php?id_grupo=$topico->grupo_id_grupo");
	}
?>