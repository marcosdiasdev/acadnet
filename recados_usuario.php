<?php
	require_once 'class/usuario.class.php';
	require_once 'class/recado.class.php';
	require_once 'action/comuns.action.php';
	include 'header.php';
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
	}
	
	$usuario = new Usuario();
	$usuario->id_usuario = (int)$_GET['id']; 
	
	if($usuario->id_usuario == $_SESSION['id_usuario']){
		header('location:meus_recados.php');
	}
	
	$recados = Recado::exibirRecados($usuario);
?>
<!------------------ Início - Container de Recados ------------------>
<div id='subcontainer_all'>				
<div id='container_recados'>
	<div id='container_postar_recados'>
		<form id="envia_recado" method="POST" action="javascript:enviaRecado()">
			<textarea class='txta_recado' type='text' placeholder='Escreva um recado...' name='texto_recado'></textarea>
			<input type='hidden' name='id_usuario' value='<?php echo $usuario->id_usuario;?>' />
			<input class='sbmt_recado' type='submit' value='Enviar' />
		</form>	
	</div>
		
	<?php
	if($recados == 0){
	?>	
			<div class='clear'></div>
			<div id="recados_aviso"><h3>Não há novos recados.</h3></div>
	<?php 
	}else{
		foreach($recados as $recado){	
			//O visitante só poderá visualizar os recados que ele tiver enviado.
			if($recado->id_remetente == $_SESSION['id_usuario']){
	?>
		<div id='container_recado<?php echo $recado->id_recado; ?>' class='container_recado'>
			<a href="usuario.php?id=<?php echo $recado->id_remetente; ?>">
				<img class="imagem_usuario_recado" src="timthumb.php?src=<?php echo $servidor.$recado->imagem_remetente;?>&h=64&w=64">
			</a>
			<div class="subcontainer_recado_cabecalho"> 
				<a href="usuario.php?id=<?php echo $recado->id_remetente; ?>">
					<span class='nome_usuario_recado'>
						<?php
						 echo $recado->nome_remetente.' '.$recado->sobrenome_remetente; 
						?>
					</span>
				</a>
				
				<span class='data_recado'>
					<?php
						echo $recado->data_recado.' às '.$recado->hora_recado;
					?>
				</span>
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
				<a href="#" onClick='javascript:apagaRecado(<?php echo $recado->id_recado; ?>,2)'>
					Excluir
				</a>
			</div>
			<br />
		</div>
		
	<?php
		}
	}
	}
	?>
</div>
</div>
<!------------------ Fim - Container Recados ------------------>
<?php include 'footer.php';?>