<?php
	require_once 'class/usuario.class.php';
	require_once 'class/recado.class.php';
	require_once 'class/grupo.class.php';
	require_once 'action/comuns.action.php';
	include("header.php");
		
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
	}
		
	$usuario_pagina = new Usuario();
	$usuario_pagina->id_usuario = (int)$_GET['id'];
	$usuario_logado = new Usuario();
	$usuario_logado->id_usuario = $_SESSION['id_usuario']; 
	
	$informacao = $usuario_pagina->exibirInformacao();

	if(!is_int($informacao) || $informacao != 0){
		$amigos = Usuario::exibirAmigos($usuario_pagina->id_usuario);
?>
		<div id='container_left'>
			<div id='subcontainer_left'>	
				<div id='container_usuario'>
					<div class='container_usuario_imagem'>
						<img class='imagem_perfil' src="timthumb.php?src=<?php echo $servidor.$informacao->imagem; ?>&h=150&w=150"/>
					</div>
					<div id="menu_usuario">	
						<a class="menu_usuario_topico" href='recados_usuario.php?id=<?php echo $informacao->id_usuario ?>'>
							<span class='menu_topico'>
								Recados
							</span>
						</a>
						<?php
							//Se for eu mesmo
							if($usuario_logado->id_usuario==$usuario_pagina->id_usuario){
						?>		
								<a class='menu_usuario_topico' href='documentos.php?id=<?php echo $informacao->id_usuario; ?>'>
									<span class="menu_topico">	
										Documentos
									</span>
								</a>							
						<?php
							//Se não for eu mesmo e for um amigo
							}elseif($usuario_logado->verificarAmizade($usuario_pagina)){
						?>		
								<a class='menu_usuario_topico' href='documentos.php?id=<?php echo $informacao->id_usuario; ?>'>
									<span class="menu_topico">	
										Documentos
									</span>
								</a>
								<a id='exclui' class='menu_usuario_topico' href='#' onClick='excluiAmigo(<?php echo $informacao->id_usuario;?>);'>
									<span class='menu_topico'>
										Desfazer amizade
									</span>
								</a>
						<?php
							// Se não for amigo e não houver solicitação de amizade pendente
							}elseif(!$usuario_logado->verificarSolicitacaoAmizade($usuario_pagina)){
						?>
								<a id='adiciona' class='menu_usuario_topico' href='#' onClick='adicionaAmigo(<?php echo $informacao->id_usuario;?>);'>
									<span class='menu_topico'>
										Adicionar
									</span>
								</a>
						<?php	
							}
						?>						
					</div>	
				</div>
			</div>			
			<div id='container_usuario_informacao'>
				<div id='subcontainer_usuario_informacao'>
					<div class='conteudo_usuario_informacao'>
					<span id='nome'><?php echo $informacao-> nome.' '.$informacao->sobrenome;?></span>
					<br />
					<span class='titulo'>
					<?php	
						echo $informacao -> status;
					?>
					</span>
					<br />
					<?php
					if($informacao -> profissao != ''){
					?>
					<b><?php echo $informacao -> profissao;?></b>
					em <b><?php echo $informacao -> empresa;?></b>
					<br>
					<?php
					}
					if($informacao -> curso != ''){
					?>	
					Cursa 
					<b><?php echo $informacao -> curso;?></b>
					em 
					<b><?php echo $informacao -> instituicao;?></b>
					<br> 
					<?php
					}
					?>				
					<span class='titulo'>Aniversário: </span>
					<?php	
					echo $informacao -> nascimento[2].'/'.$informacao->nascimento[1].'/'.$informacao->nascimento[0];
					?>
					</div>
				</div>
			</div>
		</div>
		<div id='container_right'>
<!------------------ Início - Container Amigos ------------------>
			<div class='subcontainer_right_titulo'>
				<span class='titulo_right_titulo'>
					Amigos
				</span>
			</div>
			
			<div class='subcontainer_right'>
				<?php
					foreach($amigos as $amigo){
						if(!$amigo->id_usuario==$usuario_pagina->id_usuario){
							$adiciona =	1;				
						}		
				?>
					<a href='usuario.php?id=<?php echo $amigo -> id_usuario; ?>'>
						<div class='content_box_right'>
							<img class='imagem_box_right' src="timthumb.php?src=<?php echo $servidor . $amigo->imagem; ?>&h=64&w=64">				
							<br />
							<span class="nome_amigo"><?php echo $amigo->nome.' '.$amigo->sobrenome;?></span>
						</div>
					</a>
				<?php
					}
				?>
			</div>
<!------------------ Fim - Container Amigos --------------------->
<!------------------ Início - Container Grupos ------------------>
			<div class='subcontainer_right_titulo'>
				<span class='titulo_right_titulo'>
					Grupos
				</span>
			</div>
			<div class='subcontainer_right'>
				<?php
					$grupos = Grupo::exibirGrupos($usuario_pagina);
					foreach($grupos as $grupo){
				?>
					<div class='content_box_right'>
						<a href='grupo.php?id_grupo=<?php echo $grupo->id_grupo; ?>'>
							<img class='imagem_box_right' src="timthumb.php?src=<?php echo $servidor . $grupo->imagem; ?>&h=64&w=64" />
							<span class="nome_amigo"><?php echo $grupo->nome;?></span>
						</a>
					</div>
				<?php
					}
				?>
			</div>			
<!------------------ Fim - Container Grupos ------------------>
		</div>
<div class="clear"></div>						
<?php include("footer.php"); ?>
<?php
}else{
	echo 'Esta página não existe!';
}
?>