<?php	
	require_once 'class/usuario.class.php';
	require_once 'action/comuns.action.php';
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
		exit;
	}
?>
		
<div id='subcontainer_criar_grupo'>
	<div id='botao_fechar_topo' class='fechar'>
	</div>
	
	<form action="action/edita_grupo.action.php" id='form_editar_grupo' method='post' enctype='multipart/form-data'>	
		<label class="cadastro_texto" >Nome:</label><br />
		<input class="cadastro_campo" type="text" name="nome" maxlength='45' value=""/>
		<br/>
		<label class="cadastro_texto">Descrição:</label><br />
		<input class="cadastro_campo" type="text" name="descricao" maxlength='1024' value=""/>
		<br/>
		<label class="cadastro_texto">Imagem (Máximo de 2 MB):</label><br />
		<input type="file" name="imagem" accept="image/*">
		<br />
		<input id="grupo_id_campo" type="hidden" name="id_grupo" value=""/>
		<input id="cadastro_botao" type="submit" value="Salvar"/>
	</form>
	<button class='fechar'>Cancelar</button>
</div>