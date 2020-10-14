<?php
	require_once '../class/recado.class.php';
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';

	
	$recado = new Recado();
	$remetente = new Usuario();
	$destinatario = new Usuario();
	
	$remetente->id_usuario=$_SESSION['id_usuario'];
	$remetente->nome=$_SESSION['nome_usuario'];
	$remetente->imagem=$_SESSION['imagem_usuario'];
	
	$destinatario->id_usuario=(int)$_POST['id_usuario'];
	
	$recado->texto_recado=strip_tags(addslashes($_POST['texto_recado']));
		
	if($remetente->enviarRecado($destinatario,$recado)){
?>
<div id='container_recado' class='container_recado'>
	<a href="usuario.php?id=<?php echo $remetente->id_usuario; ?>">
		<img class="imagem_usuario_recado" src="timthumb.php?src=<?php echo $servidor.$remetente->imagem; ?>&h=64&w=64">
	</a>
	<div class="subcontainer_recado_cabecalho"> 
		<a href="usuario.php?id=<?php $remetente->id_usuario;?>">
			<span class='nome_usuario_recado'>
			<?php
				$remetente->nome;
			?>
			</span>
		</a>
	</div>		
	<br />
	<div class="subcontainer_recado_texto">
		<span class='texto_recado'>
		<?php
			echo $recado->texto_recado;
		?>
		</span>
	</div>
		<div class="subcontainer_recado_rodape"> 
		</div>
		<br />
</div>
<?php 		
	}else{
		echo false;
	}
?>