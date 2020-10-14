<?php
	require_once '../class/topico.class.php';
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';

	$topico = new Topico();
	$topico->grupo_id_grupo = (int)$_POST['id_grupo'];
	$topico->conteudo_topico = strip_tags(addslashes($_POST['conteudo_topico']));  
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	$usuario->criarTopico($topico);
	header("location:../grupo.php?id_grupo=$topico->grupo_id_grupo");
?>