<?php
	require_once 'class/usuario.class.php';
	require_once 'class/recado.class.php';
	require_once 'action/comuns.action.php';
	include("header.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
	}
	
	$usuario = new Usuario;
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$recados = Recado::exibirRecados($usuario);
?>

<!------------------ Início - Container de Recados ------------------>
<div id='subcontainer_all'>
<div id='container_recados'>
	
<?php
	if($recados == 0){
?>
	<div id="recados_aviso"><h3>Não há novos recados.</h3></div>		
<?php
	}else{
		foreach($recados as $recado){
			if($recado -> imagem_remetente == ''){
				$recado -> imagem_remetente = "timthumb.php?src=".$servidor."imagem/convidado.jpg&h=64&w=64";
			}
?>
		<div id='container_recado<?php echo $recado->id_recado;?>' class="container_recado">
			<a href="usuario.php?id= <?php echo $recado->id_remetente;?> ">
				<img class="imagem_usuario_recado" src="timthumb.php?src=<?php echo $servidor.$recado->imagem_remetente;?>&h=64&w=64">
			</a>
			<div class="subcontainer_recado_cabecalho"> 
				<a href="usuario.php?id=<?php echo $recado->id_remetente;?>">
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
				<span class='texto_recado'><?php echo $recado->texto_recado;?>
				</span>
			</div>
			<div class="subcontainer_recado_rodape"> 
				<a href="#" onClick='javascript:apagaRecado(<?php echo $recado->id_recado;?>,1)'>Excluir</a>
				<a href="#" onClick='javascript:exibeResponderRecado(<?php echo $recado->id_recado;?>)'>Responder</a>
			</div>
			<div id='subcontainer_responder_recado<?php echo $recado->id_recado;?>' style='display:none;'>
				<form id='envia_recado<?php echo $recado->id_recado;?>' method='POST' 
					action='javascript:respondeRecado(<?php echo $recado->id_recado;?>)'
					>
					<textarea class='txta_responder_recado' type='text' placeholder='Escreva um recado...' name='texto_recado'></textarea>
					<br />
					<input type='hidden' name='id_usuario' value='<?php echo $recado->id_remetente;?>' />
					<input type='hidden' name='id_remetente' value='<?php echo $usuario->id_usuario;?>' />
					<input class='sbmt_responder_recado' type='submit' value='Enviar' />
				</form>
			</div>
			
		</div>
		
	<?php
		}
	}
	?>
</div>
</div>		
<!------------------ Fim - Container de Recados ------------------>	
<?php 
	include("footer.php");
?>