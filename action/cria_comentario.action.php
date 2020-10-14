<?php
	require_once '../class/comentario.class.php';
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';
	
	$comentario = new Comentario();
	$comentario->topico_id_topico = (int)$_POST['id_topico'];
	$comentario->id_grupo = (int)$_POST['id_grupo'];
	$comentario->conteudo_comentario = strip_tags(addslashes($_POST['conteudo_comentario']));
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	if($usuario->criarComentario($comentario)){
		header("location:../grupo.php?id_grupo=$comentario->id_grupo");
	} else{
		return false;
	}	
?>