<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";
	require_once '../class/documento.class.php';
	include '../header.php';
	
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$documento = new Documento();
	$documento->arquivo = $_FILES['documento'];
	$documento->titulo = strip_tags(addslashes($_POST['titulo']));
	$documento->descricao = strip_tags(addslashes($_POST['descricao']));
		
	$resultado = $usuario->enviarDocumento($documento);
	if($resultado[0]==1){
		echo "Arquivo enviado com sucesso. ".
		"<a class='menu_usuario_topico' href='../documentos.php?id=$usuario->id_usuario'>Voltar</a>"
		;			
	}else{
		echo "Erro no envio do arquivo. ".
		"<a class='menu_usuario_topico' href='../documentos.php?id=$usuario->id_usuario'>Voltar</a>"
		;
	}
	include '../footer.php';
?>