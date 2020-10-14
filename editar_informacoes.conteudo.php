<?php	
	require_once 'class/usuario.class.php';
	require_once 'action/comuns.action.php';
	
	if(!isset($_SESSION['id_usuario'])){
		header('location:index.php');
		exit;
	}
	
	$usuario = new Usuario();
	$usuario->id_usuario = $_SESSION['id_usuario'];
	$informacao = $usuario->exibirInformacao();
?>
		
<div id='editar_conteudo_container'>

	<div id='botao_fechar_topo' class='fechar'>
	</div>

	<div id='sub_editar_informacoes_left'>
		<form action="javascript:atualizaInformacoesPessoais()" id="info_pessoais" method="POST">	
			<label class="cadastro_texto">Nome:</label><br />
			<input class="cadastro_campo" type="text" name="nome" value="<?php echo $informacao ->  nome;	?>"/>
			<br/>
			<label class="cadastro_texto">Sobrenome:</label><br />
			<input class="cadastro_campo" type="text" name="sobrenome" value="<?php echo $informacao ->  sobrenome; ?>"/>
			<br/>
			<label class="cadastro_texto">Nascimento:</label><br />
			<select id="campo_dia" name="dia">
				<?php
					$dia = 1;
					while($dia < 32){
						if($dia == $informacao ->  nascimento[2]) {
							echo "<option value='".$informacao->nascimento[2]."' selected>".$informacao->nascimento[2]."</option>";									
						} else {
							echo "<option value='" . $dia . "'>" . $dia . "</option>";
						}
						$dia++;
					}
				?>
			</select>
			<select name="mes">
				<option value="<?php echo $informacao ->  nascimento[1]; ?>" selected="selected"><?php echo $informacao ->  nascimento[1]; ?>
				</option>
				<option value="01">Janeiro</option>
				<option value="02">Fevereiro</option>
				<option value="03">Março</option>
				<option value="04">Abril</option>
				<option value="05">Maio</option>
				<option value="06">Junho</option>
				<option value="07">Julho</option>
				<option value="08">Agosto</option>
				<option value="09">Setembro</option>
				<option value="10">Outubro</option>
				<option value="11">Novembro</option>
				<option value="12">Dezembro</option>
			</select>
			<select name="ano">
				<option value="<?php echo $informacao ->  nascimento[0]; ?>" 
				selected="selected"><?php echo $informacao ->  nascimento[0]; ?>
				</option>
				<?php
					$ano = 2012;
					while($ano > 1900){
						echo "<option value='" . $ano . "'>" . $ano . "</option>";
						$ano--;
					}
				?>
			</select>	
			<br>
			<label class="cadastro_texto">E-mail:</label><br />
			<input class="cadastro_campo" type="text" name="email" value="<?php echo $informacao ->  email; ?>"/>
			<br/>
			<label class="cadastro_texto">Curso:</label><br />
			<input class="cadastro_campo" type="text" name="curso" value="<?php echo $informacao->curso;?>"/>
			<br/>
			<label class="cadastro_texto">Instituição:</label><br />
			<input class="cadastro_campo" type="text" name="instituicao" value="<?php echo $informacao->instituicao; ?>"/>
			<br/>
			<label class="cadastro_texto">Profissão:</label><br />
			<input class="cadastro_campo" type="text" name="profissao" value="<?php echo $informacao->profissao;?>"/>
			<br/>
			<label class="cadastro_texto">Empresa:</label><br />
			<input class="cadastro_campo" type="text" name="empresa" value="<?php echo $informacao->empresa;?>"/>
			<br/>
			<input id="cadastro_botao" type="submit" value="Salvar"/>
		</form>
		<button class='fechar'>Cancelar</button>
	</div>
	<div id='sub_editar_informacoes_right'>
		<img class='imagem_perfil' src="timthumb.php?src=<?php echo $servidor.$informacao->imagem;?>&h=150&w=150" >
		<iframe src='iframe_altera_imagem.php'></iframe>
		<div id='sub_gerenciar_conta'>	
			<a href='altera_senha.php?codigo=<?php echo $_SESSION['codigo_senha'];?>&email=<?php echo $_SESSION['email'];?>'>Alterar Senha</a>
			<a href='excluir_conta.php'>Excluir Conta</a>
		</div>	
	</div>
</div>