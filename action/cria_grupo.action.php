<?php
	require_once "../class/grupo.class.php";
	require_once "comuns.action.php";

	$grupo = new Grupo();
	$grupo->nome = strip_tags(addslashes($_POST['nome']));
	$grupo->descricao = strip_tags(addslashes($_POST['descricao']));
	$grupo->imagem = $_FILES['imagem'];   
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario']; 
	
	$grupo = $usuario->criarGrupo($grupo);
	header("location:../grupo.php?id_grupo=$grupo");
?>