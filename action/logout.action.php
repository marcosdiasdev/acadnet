<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";
	
	if(Usuario::fazerLogout()){
		header("location:../index.php");
	}
?>