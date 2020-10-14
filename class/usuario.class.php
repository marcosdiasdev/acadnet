<?php
	require_once 'principal.class.php';
	require_once 'busca.class.php';
	
	class Usuario extends Principal {
		public $id_usuario;
		public $nome;
		public $sobrenome;
		public $nascimento;
		public $email;
		public $senha;
		public $curso;
		public $instituicao;
		public $profissao;
		public $empresa;
		public $imagem;
		public $status;
		public $codigo_redefinicao_senha;
			
		public function verificarEmail($usuario){
			$con = self::conexao();
						
			$sql = "SELECT * FROM usuario WHERE email='$usuario->email' LIMIT 1";
			$query = mysql_query($sql,$con) or die("Erro ao selecionar");
			
			if(mysql_num_rows($query)>0 ){
				return false;
			}
			return true;
		}
		
		public function cadastrarUsuario(){
			$con = self::conexao();
			
			$imagem = 'imagem/convidado.jpg';
			$codigo = md5(uniqid(time()));
			
			$insert = "INSERT INTO `usuario`(`nome`,`sobrenome`,`genero`,`nascimento`,`email`,`senha`,`imagem`,`codigo_redefinicao_senha`) 
			VALUES ('$this->nome','$this->sobrenome','$this->genero',
			'$this->nascimento','$this->email','$this->senha','$imagem','$codigo')";			
			
			$insere = mysql_query($insert,$con) or die(mysql_error());
			
			return $insere;
		}
		
		public function inserirImagem(){
				if (!empty($this->imagem["name"])) {
			 
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->imagem["name"], $ext);
		 
					$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
		 
					$caminho_imagem = "../usuario/imagem_perfil/" . $nome_imagem;
					$caminho_imagem_absoluto = "usuario/imagem_perfil/" . $nome_imagem;
		 			
					move_uploaded_file($this->imagem["tmp_name"], $caminho_imagem);
		 
					$con = self::conexao();

					$texto = "UPDATE `usuario` SET `imagem` = '$caminho_imagem_absoluto' WHERE `id_usuario` = $this->id_usuario";
					
					$resultado = array();
					$resultado[0]  = mysql_query($texto,$con);
					$resultado[1] = $caminho_imagem_absoluto;
					
					return $resultado;					
				}
		}
		
		public function fazerLogin(){
			$con = self::conexao();
			
			$sql = "SELECT id_usuario,nome,sobrenome,email,imagem,codigo_redefinicao_senha 
			FROM usuario 
			WHERE email='$this->email' 
			AND senha='$this->senha' LIMIT 1";
			$query = mysql_query($sql,$con) or die("Erro ao selecionar");
			$resultado = mysql_fetch_assoc($query);
			
			if(mysql_num_rows($query)>0 ){
			
				session_cache_expire(30);
				$_SESSION['id_usuario'] = $resultado['id_usuario'];
				$_SESSION['nome_usuario'] = $resultado['nome'].$resultado['sobrenome'];
				$_SESSION['email'] = $resultado['email'];
				$_SESSION['imagem_usuario'] = $resultado['imagem']; 
				$_SESSION['codigo_senha'] = $resultado['codigo_redefinicao_senha'];
			}
			return $resultado;
		}
		
		static function fazerLogout(){
			$con = self::conexao();
			unset($_SESSION['id_usuario'],$_SESSION['nome_usuario'],
			$_SESSION['email'],$_SESSION['imagem_usuario'],$_SESSION['codigo_senha']);
			return true;
		}
		
		public function exibirInformacao(){
			$con = self::conexao();
			
			$texto   = "SELECT * FROM usuario WHERE id_usuario = '$this->id_usuario' LIMIT 1";
			$resultado  = mysql_query($texto,$con);
			
			$linha = mysql_fetch_array($resultado);
			
			$this->nome = $linha['nome'];
			$this->sobrenome = $linha['sobrenome'];
			$this->nascimento = $linha['nascimento'];
			$this->email = $linha['email'];
			$this->instituicao = $linha['instituicao'];
			$this->curso = $linha['curso'];
			$this->empresa = $linha['empresa'];
			$this->profissao = $linha['profissao'];
			$this->imagem = $linha['imagem'];
			$this->status = $linha['status'];
			$this->nascimento = explode('-', $this -> nascimento);

			return $this;
		}
		
		public function alterarInformacoes(){
			$con = self::conexao();
			
			$texto = "UPDATE `usuario` SET 
			`nome` ='$this->nome', `sobrenome` ='$this->sobrenome', `nascimento` ='$this->nascimento',
			`email` ='$this->email', `curso` ='$this->curso', `instituicao` ='$this->instituicao',
			`profissao` ='$this->profissao',`empresa` ='$this->empresa' 
			WHERE `id_usuario` = $this->id_usuario";
			
			$resultado  = mysql_query($texto,$con);		
		}
		
		static function exibirAmigos($id_usuario){
			$con = self::conexao();
			
			$texto = "SELECT usuario.id_usuario,nome,sobrenome,imagem
			FROM usuario
			INNER JOIN amigo_rec
			ON amigo_rec.usuario_id_usuario = usuario.id_usuario
			WHERE amigo_rec.id_amigo = $id_usuario 
			AND estado = 1";
			
			$resultado  = mysql_query($texto,$con) or die('Erro ao selecionar 1.');
			
			$usuarios = array();
			
			while($linha = mysql_fetch_array($resultado)){
				$usuario = new Usuario();
				$usuario -> id_usuario = $linha['id_usuario'];
				$usuario -> nome = $linha['nome'];
				$usuario -> sobrenome = $linha['sobrenome'];
				$usuario -> imagem = $linha['imagem'];
				array_push($usuarios,$usuario);
			}
			
			$texto = "SELECT usuario.id_usuario,nome,sobrenome,imagem
			FROM usuario
			INNER JOIN amigo_rec
			ON amigo_rec.id_amigo = usuario.id_usuario
			WHERE amigo_rec.usuario_id_usuario = $id_usuario 
			AND estado = 1";
			
			$resultado  = mysql_query($texto,$con) or die('Erro ao selecionar 2.');
			
			while($linha = mysql_fetch_array($resultado)){
				$usuario = new Usuario();
				$usuario -> id_usuario = $linha['id_usuario'];
				$usuario -> nome = $linha['nome'];
				$usuario -> sobrenome = $linha['sobrenome'];
				$usuario -> imagem = $linha['imagem'];
				array_push($usuarios,$usuario);
			}
			return $usuarios;
		}

		public function adicionarAmigo($amigo){
			$con = self::conexao();
			
			$insert = "INSERT INTO `amigo_env`
			(`id_amigo`,`usuario_id_usuario`,`estado`)
			VALUES ($amigo->id_usuario,$this->id_usuario,1)";
			
			$insere = mysql_query($insert,$con) or die(mysql_error());
			
			$insert = "INSERT INTO `amigo_rec`
			(`id_amigo`,`usuario_id_usuario`,`estado`)
			VALUES ($amigo->id_usuario,$this->id_usuario,0)";
			
			$insere = mysql_query($insert,$con) or die(mysql_error());	
		}
		
		public function aceitarAdicionarAmigo($amigo){
			$con = self::conexao();
			
			$insert = "UPDATE `amigo_rec` 
			SET `estado` = 1 
			WHERE `id_amigo` = $this->id_usuario 
			AND `usuario_id_usuario` = $amigo->id_usuario";
			
			$insere = mysql_query($insert,$con) or die(mysql_error());
			
			return $insere;
		}
		
		public function rejeitarAdicionarAmigo($amigo){
			$con = self::conexao();
			
			$consulta = "DELETE FROM `acadnet`.`amigo_env` 
			WHERE id_amigo = $this->id_usuario AND usuario_id_usuario = $amigo->id_usuario";
			$insere = mysql_query($consulta,$con) or die(mysql_error());
			
			$consulta = "DELETE FROM `acadnet`.`amigo_rec` 
			WHERE id_amigo = $this->id_usuario AND usuario_id_usuario = $amigo->id_usuario";
			$insere = mysql_query($consulta,$con) or die(mysql_error());
			
			return $insere;		
		}
		
		public function excluirAmigo($amigo){
			$con = self::conexao();
			
			$consulta = "DELETE FROM `acadnet`.`amigo_env` 
			WHERE id_amigo = $this->id_usuario 
			AND usuario_id_usuario = $amigo->id_usuario";
			$insere = mysql_query($consulta,$con) or die(mysql_error());
			
			$consulta = "DELETE FROM `acadnet`.`amigo_rec` 
			WHERE id_amigo = $this->id_usuario 
			AND usuario_id_usuario = $amigo->id_usuario";
			$insere = mysql_query($consulta,$con) or die(mysql_error());
			
			$consulta = "DELETE FROM `acadnet`.`amigo_env` 
			WHERE id_amigo = $amigo->id_usuario 
			AND usuario_id_usuario = $this->id_usuario";
			$insere = mysql_query($consulta,$con) or die(mysql_error());
			
			$consulta = "DELETE FROM `acadnet`.`amigo_rec` 
			WHERE id_amigo = $amigo->id_usuario 
			AND usuario_id_usuario = $usuario->id_usuario";
			$insere = mysql_query($consulta,$con) or die(mysql_error());
			
			return $insere;		
		}		
		
		public function verificarAdicoes(){
			$con = self::conexao();
			
			$texto = "SELECT
			usuario.id_usuario,usuario.nome,usuario.sobrenome,usuario.imagem
			FROM amigo_rec
			INNER JOIN usuario
			ON amigo_rec.usuario_id_usuario = usuario.id_usuario
			WHERE amigo_rec.id_amigo = $this->id_usuario
			AND estado = 0";
			
			$resultado  = mysql_query($texto,$con);
			
			$usuarios = array();
			
			while($linha = mysql_fetch_array($resultado)){
				$usuario = new Usuario();
				$usuario->id_usuario = $linha['id_usuario'];
				$usuario->nome = $linha['nome'];
				$usuario->sobrenome = $linha['sobrenome'];
				$usuario->imagem = $linha['imagem'];
				array_push($usuarios,$usuario);
			}
			return $usuarios;
		}		
		
		public function verificarAmizade($usuario_pagina){
			$con = self::conexao();
			
			$texto = "SELECT * FROM amigo_rec 
			WHERE usuario_id_usuario = $this->id_usuario 
			AND id_amigo = $usuario_pagina->id_usuario 
			AND estado = 1 LIMIT 1";
			$query = mysql_query($texto,$con) or die("Erro ao selecionar");
			if(mysql_num_rows($query)>0){
				return true;
			} else {
				$texto = "SELECT * FROM amigo_rec 
				WHERE usuario_id_usuario = $usuario_pagina->id_usuario 
				AND id_amigo = $this->id_usuario 
				AND estado = 1 LIMIT 1";
				$query = mysql_query($texto,$con) or die("Erro ao selecionar");
				if(mysql_num_rows($query)>0){
					return true;
				} else {
					return false;
				}
			}
		}

		public function verificarSolicitacaoAmizade($usuario_pagina){
			$con = self::conexao();
			
			$texto = "SELECT * FROM amigo_rec 
			WHERE usuario_id_usuario = $this->id_usuario 
			AND id_amigo = $usuario_pagina->id_usuario 
			AND estado = 0 LIMIT 1";
			$query = mysql_query($texto,$con) or die("Erro ao selecionar");
			if(mysql_num_rows($query)>0){
				return true;
			} else {
				$texto = "SELECT * FROM amigo_rec 
				WHERE usuario_id_usuario = $usuario_pagina->id_usuario 
				AND id_amigo = $this->id_usuario 
				AND estado = 0 LIMIT 1";
				$query = mysql_query($texto,$con) or die("Erro ao selecionar");
				if(mysql_num_rows($query)>0){
					return true;
				} else {
					return false;
				}
			}
		}		
		
		public function alterarStatus(){
			$con = self::conexao();
			
			$texto = "UPDATE `usuario` 
			SET `status` ='$this->status' 
			WHERE `id_usuario` = $this->id_usuario";
			
			$resultado  = mysql_query($texto,$con);
		}
		
		public function gerarCodigoRedefinicaoSenha(){
			$con = self::conexao();
			
			$codigo = md5(uniqid(time()));
			
			$texto = "UPDATE `usuario` 
			SET `codigo_redefinicao_senha` ='$codigo' 
			WHERE `email` ='$this->email'";
			
			if($resultado = mysql_query($texto,$con)){			
				return $codigo;
			}else{
				return $resultado;
			}
		}
		
		public function alterarSenha(){
			$con = self::conexao();
			
			$texto = "UPDATE `usuario` 
			SET `senha` ='$this->senha' 
			WHERE `codigo_redefinicao_senha` ='$this->codigo_redefinicao_senha' 
			AND `email` ='$this->email'"; 
			$resultado = mysql_query($texto,$con);
			return $resultado;		
		}

		static function buscarConteudo($nome_item){
			$con = self::conexao();
			
			$busca = array();
			
			$texto = "SELECT 
			id_usuario,nome,sobrenome,imagem
			FROM usuario 
			WHERE nome LIKE '%$nome_item%'
			ORDER BY nome desc";
			
			$resultado = mysql_query($texto,$con) or die ('Erro ao selecionar 1.');

			while($linha = mysql_fetch_array($resultado)){
				$item = new Busca($linha['id_usuario'],$linha['nome'].' '.$linha['sobrenome'],$linha['imagem'],'Usuário');
				array_push($busca,$item);
			}
			
			$texto = "SELECT 
			id_grupo,nome,imagem
			FROM grupo 
			WHERE nome LIKE '%$nome_item%'
			ORDER BY nome desc";
			$resultado = mysql_query($texto,$con) or die ('Erro ao selecionar 2.');
			
			while($linha = mysql_fetch_array($resultado)){
				$item = new Busca($linha['id_grupo'],$linha['nome'],$linha['imagem'],'Grupo');
				array_push($busca,$item);
			}
			return $busca;
		}
		
		public function excluirConta(){
			$con = self::conexao();
			
			$id_usuario = $this->id_usuario;
			$senha = $this->senha;
			
			$id_usuario = strip_tags(addslashes($id_usuario));
			$senha = strip_tags(addslashes($senha));
			
			$sql = "SELECT id_usuario
			FROM usuario
			WHERE id_usuario=$id_usuario 
			AND senha='$senha' LIMIT 1";
			
			$query = mysql_query($sql,$con) or die("Erro ao selecionar 1.");
			
			if(mysql_num_rows($query)>0 ){

				$sql = "DELETE FROM acadnet.comentario 
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 2.");

				$sql = "DELETE FROM acadnet.topico 
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 3.");
				
				$sql = "DELETE FROM acadnet.grupo_has_usuario 
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 4.");
				
				$sql = "DELETE FROM acadnet.grupo 
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 5.");
				
				$sql = "DELETE FROM acadnet.recado 
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 6.");
				
				$sql = "DELETE FROM acadnet.recado
				WHERE usuario_id_remetente=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 7.");
				
				$sql = "DELETE FROM acadnet.documento
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 8.");
				
				$sql = "DELETE FROM acadnet.amigo_rec
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 9.");
				
				$sql = "DELETE FROM acadnet.amigo_rec
				WHERE id_amigo=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 10.");
				
				$sql = "DELETE FROM acadnet.amigo_env
				WHERE usuario_id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 11.");
				
				$sql = "DELETE FROM acadnet.amigo_env
				WHERE id_amigo=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 12.");

				$sql = "DELETE FROM acadnet.usuario
				WHERE id_usuario=$id_usuario";
				$query = mysql_query($sql,$con) or die("Erro ao selecionar 13.");	
				
				$this->logout();
				return true;
			
			} else {
				return false;
			}
		}
		
		public function enviarRecado($destinatario,$recado){
			$con = self::conexao();
			
			$data = date("Y/m/d H:i:s");
			
			$texto   = "INSERT INTO `recado` 
			(`usuario_id_usuario`, `usuario_id_remetente`, `texto_recado`, `data_recado`)
			VALUES ('$destinatario->id_usuario','$this->id_usuario','$recado->texto_recado','$data')";	
			$resultado  = mysql_query($texto,$con);
			return true;	
		}
		
		public function apagarRecadoRecebido($recado){
			$con = self::conexao();
			$texto = "DELETE FROM `acadnet`.`recado` 
			WHERE id_recado = $recado->id_recado 
			AND usuario_id_usuario = $this->id_usuario";
			$result  = mysql_query($texto,$con);
		}
		
		public function apagarRecadoEnviado($recado){
			$con = self::conexao();
			$texto = "DELETE FROM `acadnet`.`recado` 
			WHERE id_recado = $recado->id_recado 
			AND usuario_id_remetente = $this->id_usuario";
			$result  = mysql_query($texto,$con);
		}
		
		public function enviarDocumento($documento){
			if (!empty($documento->arquivo["name"])) {

		 		$data = date("Y/m/d H:i:s");

		 		preg_match("/\.(doc|docx|txt|pdf|xls|xlsx|ppt|pptx|odt){1}$/i", $documento->arquivo["name"], $ext);
	 				 		
		 		$nome_documento = date("Y_m_d-h_i_s_") . $documento->arquivo["name"];
		 		
		 		$nome_documento = str_replace(" ","",$nome_documento);
		 		
		 		$nome_documento = strtr($nome_documento, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", 
  				"aaaaeeiooouucAAAAEEIOOOUUC_");
				$caminho_documento = "../usuario/documento/" . $nome_documento;
				$caminho_documento_absoluto = "usuario/documento/".$nome_documento;
	 
				move_uploaded_file($documento->arquivo["tmp_name"], $caminho_documento);
	 
				$con = self::conexao();

				$texto = "INSERT INTO `documento` 
				VALUES ('','$documento->titulo','$documento->descricao',
				$this->id_usuario,'$data','$caminho_documento_absoluto')";
				
				$resultado = array();
				$resultado[0]  = mysql_query($texto,$con);
				$resultado[1] = $caminho_documento_absoluto;
				
				return $resultado;
			}
		}
		
		public function excluirDocumento($documento){
			$con = self::conexao();
			
			$texto = "SELECT `caminho` FROM `documento` 
			WHERE id_documento = $documento->id_documento 
			AND usuario_id_usuario = $this->id_usuario";
			$query = mysql_query($texto,$con) or die("Erro ao selecionar");
			
			if(mysql_num_rows($query)>0){
				$linha = mysql_fetch_array($query);
				$documento->caminho = "../".$linha['caminho'];
				$texto = "DELETE FROM `acadnet`.`documento` 
				WHERE id_documento = $documento->id_documento 
				AND usuario_id_usuario = $this->id_usuario";
				$query  = mysql_query($texto,$con) or die("Erro ao selecionar");
				
				if($this->excluirArquivo($documento->caminho)){
					return true;	
				}
			} else {
				return false;
			}
		}
		
		public function criarGrupo($grupo){
			if (!empty($grupo->imagem['name'])) {
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $grupo->imagem['name'], $ext);
				$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
	 
				$caminho_imagem = "../usuario/grupo/" . $nome_imagem;
				$imagem = "usuario/grupo/" . $nome_imagem;
	 
				move_uploaded_file($grupo->imagem["tmp_name"], $caminho_imagem);
			} else {
				$imagem = "imagem/grupo.jpg";
			}
			
			$con = self::conexao();
			
			$data = date("Y-m-d");
			
			$texto = "INSERT INTO grupo 
			(`nome`,`descricao`,`data_criacao`,`usuario_id_usuario`,`imagem`) 
			VALUES ('$grupo->nome','$grupo->descricao','$data',$this->id_usuario,'$imagem')";
			
			$resultado = mysql_query($texto,$con) or die("Erro ao selecionar 1");
			
			$texto = "SHOW TABLE STATUS LIKE 'grupo'";
			$resultado = mysql_query($texto,$con);
			$row = mysql_fetch_array($resultado);
			$proximo_id = $row['Auto_increment'];
			$grupo_id_grupo = $proximo_id -1;
			mysql_free_result($resultado);
			
			$texto = 
			"INSERT INTO grupo_has_usuario 
			VALUES ($grupo_id_grupo,$this->id_usuario,1)";
			
			$resultado = mysql_query($texto,$con) or die("Erro ao selecionar 2");
			return $grupo_id_grupo;
		}
		
		public function participarGrupo($grupo){
			$con = self::conexao();
			
			$texto = "INSERT INTO grupo_has_usuario 
			VALUES ($grupo->id_grupo,$this->id_usuario,1)";
			mysql_query($texto,$con) or die("Erro ao selecionar");
			
			return true;
		}
		
		public function deixarGrupo($grupo){
			$con = self::conexao();
			
			$texto = "DELETE FROM `acadnet`.`grupo_has_usuario`
			WHERE grupo_id_grupo = $grupo->id_grupo  
			AND usuario_id_usuario = $this->id_usuario";
			mysql_query($texto,$con) or die("Erro ao selecionar");
			
			return true;
		}
		
		public function excluirGrupo($grupo){
			$con = self::conexao();

			$texto = "SELECT imagem 
			FROM grupo
			WHERE id_grupo = $grupo->id_grupo";
			$query = mysql_query($texto,$con) or die("Erro ao selecionar 1.");
			$linha = mysql_fetch_array($query);
			$imagem = "../".$linha['imagem'];
			
			$texto = "DELETE FROM `acadnet`.`grupo_has_usuario`
			WHERE grupo_id_grupo = $grupo->id_grupo
			AND usuario_id_usuario = $this->id_usuario";
			mysql_query($texto,$con) or die("Erro ao selecionar 2.");			
			
			$texto = "DELETE FROM `acadnet`.`grupo`
			WHERE id_grupo = $grupo->id_grupo  
			AND usuario_id_usuario = $this->id_usuario";
			mysql_query($texto,$con) or die("Erro ao selecionar 3.");
			
			if($imagem != "../imagem/grupo.jpg"){
				if($this->excluirArquivo($imagem)){
					return true;
				}				
			}
			return true;
		}
		
		public function editarGrupo($grupo){
			if (!empty($grupo->imagem["name"])) {
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $grupo->imagem["name"], $ext);
				$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
	 
				$caminho_imagem = "../usuario/grupo/" . $nome_imagem;
				$imagem = "usuario/grupo/" . $nome_imagem;
	 
				move_uploaded_file($grupo->imagem["tmp_name"], $caminho_imagem);
			} else {
				$imagem = "imagem/grupo.jpg";
			}

			$con = self::conexao();

			$texto = "UPDATE `grupo` 
			SET `nome` = '$grupo->nome', `descricao` = '$grupo->descricao', `imagem` = '$imagem' 
			WHERE `id_grupo` = $grupo->id_grupo
			AND `usuario_id_usuario` = $this->id_usuario";
			
			$resultado = mysql_query($texto,$con) or die("Erro ao selecionar 1");

			return true;
		}

		
		public function criarTopico($topico){
			$con = self::conexao();
			
			$data_topico = date("Y-m-d H:i:s");
			
			$texto = "INSERT INTO 
			topico (`conteudo_topico`,`data_topico`,`usuario_id_usuario`,`grupo_id_grupo`) 
			VALUES ('$topico->conteudo_topico','$data_topico',$this->id_usuario,$topico->grupo_id_grupo)";
			
			$resultado = mysql_query($texto,$con) or die("Erro ao selecionar");

			return true;
		}
		
		public function excluirTopico($topico){
			$con = self::conexao();

			$texto = "DELETE FROM `acadnet`.`comentario`
			WHERE topico_id_topico = $topico->id_topico";
			mysql_query($texto,$con) or die("Erro ao selecionar");			
			
			$texto = "DELETE FROM `acadnet`.`topico`
			WHERE id_topico = $topico->id_topico  
			AND usuario_id_usuario = $this->id_usuario";
			mysql_query($texto,$con) or die("Erro ao selecionar");
			
			return true;
		}
		
		public function criarComentario($comentario){
			$con = self::conexao();
			
			$data_comentario = date("Y-m-d H:i:s");
			
			$texto = "INSERT INTO 
			comentario (`conteudo_comentario`,`data_comentario`,`usuario_id_usuario`,`topico_id_topico`) 
			VALUES ('$comentario->conteudo_comentario','$data_comentario',$this->id_usuario,$comentario->topico_id_topico)";
			
			$resultado = mysql_query($texto,$con) or die("Erro ao selecionar");

			return true;
		}
		
		public function excluirComentario($comentario){
			$con = self::conexao();

			$texto = "DELETE FROM `acadnet`.`comentario`
			WHERE id_comentario = $comentario->id_comentario  
			AND usuario_id_usuario = $this->id_usuario";
			mysql_query($texto,$con) or die("Erro ao selecionar");
			
			return true;
		}
		
	}
?>