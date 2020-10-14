<?php
	require_once '../class/usuario.class.php';
	require_once '../class/recado.class.php';
	require_once 'comuns.action.php';
	
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$recado = new Recado();
	$recado->id_recado = (int)$_GET['id_recado'];
	
	$num_metodo = (int)$_GET['num_metodo'];
	
	if($num_metodo == 1)
	{
		$texto = $usuario->apagarRecadoRecebido($recado);
		echo true;
		exit;
	}
	else
	{
		$texto = $usuario->apagarRecadoEnviado($recado);
		echo true;
		exit;
	}
	echo false;
?>