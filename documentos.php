<?php
	require_once 'class/usuario.class.php';
	require_once 'class/recado.class.php';
	require_once 'class/documento.class.php';
	require_once 'action/comuns.action.php';
	include("header.php");
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
	}
	
	$usuario_pagina = new Usuario();
	$usuario_pagina->id_usuario = (int)$_GET['id'];
	$usuario_logado = new Usuario();
	$usuario_logado->id_usuario = ($_SESSION['id_usuario']);
	
	if($usuario_pagina->id_usuario == $usuario_logado->id_usuario){
		$proprietario = true;
		$documentos = Documento::exibirDocumentos($usuario_pagina->id_usuario);
?>
<div id='subcontainer_all'>
	<div id='container-form-documento'>
		<form action="action/envia_documento.action.php" method="post" enctype="multipart/form-data">
			<input type="file" name="documento" accept="MIME_type"><br />
			<label class="cadastro_texto">Título:</label><br />
			<input class="cadastro_campo" type="text" name="titulo" maxlength='45' value=""/><br />
			<label class="cadastro_texto">Descrição:</label><br />
			<input class="cadastro_campo" type="text" name="descricao" maxlength='100' value=""/><br />
			<input type="submit" value="Enviar Documento">
		</form>
	</div>
<?php
	} else {
		if($usuario_logado->verificarAmizade($usuario_pagina)){
			$documentos = Documento::exibirDocumentos($usuario_pagina->id_usuario);
			$proprietario = false;
		} else {
			header('location:home.php');
		}
	}
	
	if($documentos){
		foreach($documentos as $documento){
?>		
		<div class="container_documento">
			<?php 
				if($proprietario){
					echo "<a class='excluir_documento' href='action/exclui_documento.action.php?id=".$documento->id_documento."'>Excluir</a>";
				}
			?>
			<a href="<?php echo $documento->caminho?>" title='<?php echo $documento->titulo." - ".$documento->descricao;?>'>
				<img src="imagem/document_icon.png"/><br />
				<span class='titulo_documento'><?php echo $documento->titulo;?></span>
			</a>
		</div>	
<?php
		}
	} else {
?>		
		<div id="recados_aviso"><h3>Não há novos documentos.</h3></div>
<?php		
	}
?>
<div class="clear"></div>
</div>
<?php 
	include("footer.php");
?>