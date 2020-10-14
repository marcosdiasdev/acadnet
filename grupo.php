<?php
	require_once 'class/usuario.class.php';
	require_once 'class/grupo.class.php';
	require_once 'class/topico.class.php';
	require_once 'class/comentario.class.php';
	require_once 'action/comuns.action.php';
	include("header.php");
		
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
	}
	
	$usuario = new Usuario;
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$grupo = new Grupo;
	$grupo->id_grupo = (int)$_GET['id_grupo'];
		
	
	$info_grupo = Grupo::exibirInformacaoGrupo($grupo);

	if(!is_int($info_grupo) || $info_grupo != 0){
	
		$usuarios_grupo = Grupo::exibirUsuariosGrupo($grupo);
		
		// Verifica se È o propriet·rio. Se n„o, verifica se È participante.
		$participa = false;
		$proprietario = false;
		if ($info_grupo->usuario_id_usuario == $usuario->id_usuario) {
			$proprietario = true;
		} else {
			$participa = $grupo->verificarParticipacaoGrupo($usuario);
		}
		
		// Define menu para propriet√°rios e usu√°rios comuns.
		if(!$participa && !$proprietario){
			$opcoes = "<a class='menu_usuario_topico' href='action/participa_grupo.action.php?id_grupo=".$grupo->id_grupo."'><span class='menu_topico'>Participar</span></a>";
		} elseif($participa && !$proprietario){
			$opcoes = "<a class='menu_usuario_topico' href='action/deixa_grupo.action.php?id_grupo=".$grupo->id_grupo."'><span class='menu_topico'>Deixar Grupo</span></a>";
			$conteudo;
		} else {
			// Se for o propriet√°rio.
			$opcoes = "<a class='menu_usuario_topico' href='action/exclui_grupo.action.php?id_grupo=".$grupo->id_grupo."'><span class='menu_topico'>Excluir Grupo</span></a>".
			"<a class='menu_usuario_topico' href='#' onclick='exibeEditaGrupo(\"#container_criar_grupo\",\"edita_grupo.conteudo.php\",\"".$grupo->id_grupo."\");'><span class='menu_topico'>Editar Grupo</span></a>";
		}
?>
<!-- ----------Left ----------------- -->
		<div id='grupo_container_left'>
			<div id='grupo_subcontainer_left'>
				<div id='container_usuario'>
						<div class='container_usuario_imagem'>
							<a href="">	
								<img id='imagem_perfil' class='imagem_perfil' src="timthumb.php?src=<?php echo $servidor.$info_grupo -> imagem;?>&h=150&w=150"/>
							</a>
						</div>
					<div id='menu_usuario'>	
						<?php echo $opcoes;?>
					</div>	
				</div>
			</div>
			<div id='container_grupo_informacao'>
<!-- ------------- Centro -------------- -->				
				<div id='info_grupo'>
					<h2 id="nome_grupo">
						<?php echo $info_grupo -> nome;?>
					</h2><br />
					<p id="descricao_grupo">
						<?php echo $info_grupo -> descricao;?>
					</p>
				</div>
				
				<div class="clear"></div>
				
				<div id="container_conteudo_grupo">
					<?php
						// Imprime t√≥picos
						if($participa || $proprietario){
					?>
							<div id='container_cria_topico'>
								<form id='cria_topico' method='POST' action='action/cria_topico.action.php'>
									<textarea id='txta-cria-topico' type='text' placeholder='Compartilhe algo.' name='conteudo_topico' maxlength='2048'></textarea>
									<input type='hidden' name='id_usuario' value='<?php echo $usuario->id_usuario;?>'/>
									<input type='hidden' name='id_grupo' value='<?php echo $grupo->id_grupo;?>'/>
									<input id='snd-cria-topico' type='submit' value='Enviar' />
								</form>
							</div>
							
							<div id="container-topicos">
					<?php
							if($topicos = Topico::exibirTopicos($grupo)){
							foreach ($topicos as $topico){
					?>
								<div class='container-single-topico'>
					<?php 
								if($topico->id_usuario==$usuario->id_usuario){
									echo "<a href='action/exclui_topico.action.php?id_topico=".$topico->id_topico."&id_grupo=".$grupo->id_grupo."'><span>Excluir</span></a>";
								}	
					?>
									<a class='anc-img-topico' href='usuario?id=<?php echo $topico -> id_usuario;?>'>
										<img class='imagem_perfil' 
										src="timthumb.php?src=
										<?php echo $servidor.$topico -> imagem;?>&h=64&w=64">
									</a>
									<div class='container-right-topico'>
										<div class='content-topico'>
											<a href='usuario?id=<?php echo $topico -> id_usuario;?>'>
												<h4><?php echo $topico->nome." ".$topico->sobrenome;?></h4>
											</a><br />
											<span class='txt-content-topico'>	
												<?php echo $topico -> conteudo_topico;;?>
											</span>
										</div>
										<div class='content-info-topico'>
											<?php echo $topico -> data_topico;?>
										</div>
						<?php
								$topico2 = new Topico();
								$topico2->topico_id_topico = $topico -> id_topico;
								
								if($comentarios = Comentario::exibirComentarios($topico2)){
									foreach ($comentarios as $comentario){
						?>
									<div class='container-single-comentario'>
									
						<?php 
								if($comentario->id_usuario==$usuario->id_usuario){
									echo "<a href='action/exclui_comentario.action.php?id_comentario=".$comentario->id_comentario."&id_grupo=".$grupo->id_grupo."'><span>Excluir</span></a>";
								}
						?>			
										<a class='anc-img-comentario' href='usuario?id=<?php echo $comentario -> id_usuario;?>'>
											<img class='imagem_perfil' 
											src="timthumb.php?src=
											<?php echo $servidor.$comentario -> imagem;?>&h=34&w=34" />
										</a>
										<div class='container-right-comentario'>
											<div class='content-comentario'>
												<a href='usuario?id=<?php echo $comentario -> id_usuario;?>'>
													<h4><?php echo $comentario->nome." ".$comentario->sobrenome;?></h4>
												</a><br />
												<span class='txt-content-comentario'>	
													<?php echo $comentario -> conteudo_comentario;;?>
												</span>
											</div>
										</div>	
									</div>
						<?php
									}
								}
						?>
									<div id='container_cria_comentario'>
										<form id='cria_comentario<?php echo $topico -> id_topico;?>' method='POST' action='action/cria_comentario.action.php'>
											<textarea class='txta-cria-comentario' type='text' placeholder='Compartilhe algo.' name='conteudo_comentario'></textarea>
											<input type='hidden' name='id_usuario' value='<?php echo $usuario->id_usuario;?>'/>
											<input type='hidden' name='id_topico' value='<?php echo $topico -> id_topico;?>'/>
											<input type='hidden' name='id_grupo' value='<?php echo $grupo->id_grupo;?>'/>
											<input type='submit' value='Enviar' />
										</form>
									</div>
								</div>	
							</div>	
						<?php
							}
						}
						} else {
							echo "Participe para ter acesso ao conte√∫do do grupo.";	
						}
					?>
						</div>
				</div>
				
			</div>
		</div>
<!----------------EndLeft--------------------->
		<div id='grupo_container_right'>
<!----------------StartRight------------------>
			<div class='grupo_subcontainer_right'>
				<?php
					foreach($usuarios_grupo as $usuario){
				?>
						<a href='usuario.php?id=<?php echo $usuario->id_usuario;?>' title='<?php echo $usuario->nome.' '.$usuario->sobrenome;?>'>	
							<img id='imagem_perfil' class='imagem_perfil' alt='<?php echo $usuario->nome.' '.$usuario->sobrenome;?>' 
							src="timthumb.php?src=
							<?php echo $servidor . $usuario->imagem; ?>&h=97&w=97"/>
						</a>
				<?php
					}
				?>
			</div>
<!------------------ Fim - Container de Amigos ------------------>
		</div>
<div class="clear"></div>
<?php include("footer.php"); ?>
<?php
	}else{
		echo 'Esta p√°gina n√£o existe!';
	}
?>