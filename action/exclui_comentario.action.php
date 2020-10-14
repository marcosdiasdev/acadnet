<?php
	require_once '../class/comentario.class.php';
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';
	
	$comentario = new Comentario();
	$comentario->id_comentario = (int)$_GET['id_comentario'];
	$comentario->grupo_id_grupo = (int)$_GET['id_grupo'];
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	if($usuario->excluirComentario($comentario)){
		header("location:../grupo.php?id_grupo=$comentario->grupo_id_grupo");
	}
?>