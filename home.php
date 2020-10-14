<?php
	require_once 'class/usuario.class.php';
	require_once 'class/recado.class.php';
	require_once 'class/grupo.class.php';
	require_once 'action/comuns.action.php';
	include("header.php");
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
		exit;
	}
	
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	
	$solicitacoes_amizade = $usuario->verificarAdicoes();
	
	$informacao = $usuario->exibirInformacao();
?>
<!-- ---------------- Inicio - Left ----------------- -->
		<div id='container_left'>
			<div id='subcontainer_left'>
				<div id='container_usuario'>
						<div class='container_usuario_imagem'>
							<a href="usuario.php?id=<?php echo $informacao->id_usuario;?>">	
								<img id='imagem_perfil' class='imagem_perfil' src="timthumb.php?src=<?php echo $servidor . $informacao->imagem; ?>&h=150&w=150"/>
							</a>
						</div>
					<div id='menu_usuario'>	
						<a class="menu_usuario_topico" href="#" onclick='exibeEditarInformacoes("#subcontainer_editar_informacoes","editar_informacoes.conteudo.php");'>
							<span class="menu_topico">Editar Informações</span>
						</a>
						<a class="menu_usuario_topico" href="meus_recados.php">
							<span class="menu_topico">	
								Meus Recados
							</span>
						</a>
						<a class="menu_usuario_topico" href="documentos.php?id=<?php echo $informacao -> id_usuario; ?>">
							<span class="menu_topico">	
								Documentos
							</span>
						</a>
						<a class="menu_usuario_topico" href="#" onclick='exibeCriaGrupo("#container_criar_grupo","cria_grupo.conteudo.php");'>
							<span class="menu_topico">	
								Criar Grupo
							</span>
						</a>
					</div>	
				</div>
			</div>
			<div id='container_usuario_informacao'>
				<div id='subcontainer_usuario_informacao'>
<!------------------ Início - Informações Dinâmicas ---------------->				
					<div class='conteudo_usuario_informacao'>
						<span id='nome'><?php echo "Olá, " . $informacao ->  nome ." ". $informacao -> sobrenome; ?></span><br />
						<span id='status'><?php echo $informacao -> status; ?></span>
						<form id='formStatus' action='javascript:alteraStatus()' method='post'>	
							<input id='status_campo' type='text' name='status' />
							<input id='status_botao' type='submit' value='Atualizar'/>
						</form>
					</div>
<!------------------ Fim - Informações Dinâmicas ------------------>				
				</div>
<!------------------ Início - Container de Notificações ------------------>	
				<div id='container_notificacoes'>
					<?php
						$num_notificacao = 0;
						if($solicitacoes_amizade){
					?>		
							<hr class='separador'/>
							<div class='conteudo_usuario_informacao'>
							<h3>Solicitações de Amizade</h3>
					<?php
							foreach($solicitacoes_amizade as $amigo){
					?>
							<div id="notificacao<?php echo $num_notificacao;?>" class='container_solicitacao_amizade'>
								<div class='container_imagem_solicitacao_amizade'>
									<a href='usuario.php?id=<?php echo $amigo->id_usuario; ?>' class='link_usuario_solicitacao'>
										<img class='imagem_solicitacao_amizade' src="timthumb.php?src=<?php echo $servidor . $amigo->imagem; ?>&h=50&w=50">
									</a>
								</div>
								<div class='container_dados_solicitacao_amizade'>
								<a href='usuario.php?id=<?php echo $amigo->id_usuario; ?>' class='link_usuario_solicitacao'>
									<h4><?php echo $amigo -> nome . ' ' . $amigo -> sobrenome;?></h4><br />
								</a>
									<a href='#' onclick='javascript:aceitaAdicionaAmigo(<?php echo $amigo->id_usuario; ?>,<?php echo $num_notificacao;?>)'>Aceitar</a>
									<a href='#' onclick='javascript:rejeitaAdicionaAmigo(<?php echo $amigo->id_usuario; ?>,<?php echo $num_notificacao;?>)'>Rejeitar</a>
								</div>
							</div>
							<div class='clear'></div>
					<?php
							$num_notificacao++;
							}
					?>		
						</div>
					<?php 		
						}
					?>
				</div>
<!------------------ Fim - Container de Notificacoes --------------------->
			</div>
		</div>
<!------------------ Fim - Left ---------------------------------->
		<div id='container_right'>
<!------------------ Início - Container de Amigos ------------------>

			<div class='subcontainer_right_titulo'>
				<span class='titulo_right_titulo'>
					Amigos
				</span>
			</div>
			
			<div class='subcontainer_right'>
				<?php
					$amigos = Usuario::exibirAmigos($usuario->id_usuario);
					foreach($amigos as $amigo){
				?>
					<a href='usuario.php?id=<?php echo $amigo -> id_usuario; ?>' title='<?php echo $amigo->nome.' '.$amigo->sobrenome;?>'>
						<div class="content_box_right">
							<img class='imagem_box_right' src="timthumb.php?src=<?php echo $servidor . $amigo->imagem; ?>&h=64&w=64" />
							<span class="nome_amigo"><?php echo $amigo->nome.' '.$amigo->sobrenome;?></span>
						</div>
					</a>
				<?php
					}
				?>
			</div>
<!------------------ Fim - Container de Amigos ------------------>
<!------------------ Início - Container de Grupos ------------------>			
			<div class='subcontainer_right_titulo'>
				<span class='titulo_right_titulo'>
					Grupos
				</span>
			</div>
			<div class='subcontainer_right'>
				<?php
					$grupos = Grupo::exibirGrupos($usuario);
					foreach($grupos as $grupo){
				?>
					<div class='content_box_right'>
						<a href='grupo.php?id_grupo=<?php echo $grupo->id_grupo; ?>' title='<?php echo $grupo->nome;?>'>
							<img class='imagem_box_right' src="timthumb.php?src=<?php echo $servidor . $grupo->imagem; ?>&h=64&w=64" />
							<span class="nome_amigo"><?php echo $grupo->nome;?></span>
						</a>
					</div>
				<?php
					}
				?>
			</div>
<!------------------ Fim - Container de Grupos ------------------>
		</div>
<div class="clear"></div>		
<?php include("footer.php"); ?>