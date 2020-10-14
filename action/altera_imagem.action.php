<?php
	require_once "../class/usuario.class.php";
	require_once "comuns.action.php";
	
		echo '
			<link rel="stylesheet" type="text/css" href="../style/style.css"/>
			<script>
				window.parent.$(".imagem_perfil").toggle();
			</script>
		';
		
		$usuario = new Usuario();
		$usuario->id_usuario = $_SESSION['id_usuario'];
		$usuario->imagem = $_FILES['foto'];
		
		$resultado = $usuario->inserirImagem();
		
		if($resultado[0]==1){
			echo '
				<script>
					window.parent.$(".imagem_perfil").toggle();
					window.parent.$(".imagem_perfil").attr("src","timthumb.php?src='.$servidor.$resultado[1].'&h=150&w=150");		
				</script>
				<form action="altera_imagem.action.php" method="post"  enctype="multipart/form-data">
					<label class="cadastro_texto">Imagem (Máximo de 2 MB):</label><br />	
					<input type="file" name="foto" accept="image/*>
					<br />
					<input type="submit" value="Enviar Foto!">
				<form>
				';			
		}else{
			echo 'Erro no envio do arquivo. Recarregue a p�gina e tente novamente.';
		}
?>
