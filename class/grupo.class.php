<?php
	require_once 'principal.class.php';
	require_once 'usuario.class.php';
	
	class Grupo extends Principal {
		public $id_grupo;
		public $nome;
		public $descricao;
		public $data_criacao;
		public $usuario_id_usuario;		
		public $imagem;
		
		static function exibirGrupos($usuario){
			$con = self::conexao();
			
			$texto = 
			"SELECT nome, id_grupo, imagem FROM grupo 
			INNER JOIN grupo_has_usuario 
			ON grupo_has_usuario.grupo_id_grupo=grupo.id_grupo
			WHERE grupo_has_usuario.usuario_id_usuario = $usuario->id_usuario 
			AND grupo_has_usuario.estado = 1";
			
			$resultado  = mysql_query($texto,$con);
			
			$grupos = array();
			
			while($linha = mysql_fetch_array($resultado)){
				$grupo = new Grupo();
				$grupo -> id_grupo = $linha['id_grupo'];
				$grupo -> nome = $linha['nome'];
				$grupo -> imagem = $linha['imagem'];
				array_push($grupos,$grupo);
			}
			return $grupos;
		}
			
		static function exibirInformacaoGrupo($grupo){
			$con = self::conexao();
			
			$texto = "SELECT * FROM grupo WHERE id_grupo = $grupo->id_grupo";
			$resultado  = mysql_query($texto,$con);
			
			if(mysql_num_rows($resultado)>0 ){

				$linha = mysql_fetch_array($resultado);
				
				$grupo = new Grupo;
				$grupo -> id_grupo = $linha['id_grupo'];
				$grupo -> nome = $linha['nome'];
				$grupo -> descricao = $linha['descricao'];
				$grupo -> data_criacao = $linha['data_criacao'];
				$grupo -> data_criacao = explode('-', $grupo -> data_criacao);
				$grupo -> data_criacao = $grupo -> data_criacao[2]. '/'.$grupo -> data_criacao[1]. '/'.$grupo -> data_criacao[0];
				$grupo -> usuario_id_usuario = $linha['usuario_id_usuario'];
				$grupo -> imagem = $linha['imagem'];				
			}else{
				$grupo = 0;
			}
			return $grupo;
		}

		static function exibirUsuariosGrupo($grupo){
			$con = self::conexao();
			
			$texto = "SELECT 
			usuario.id_usuario,usuario.nome,usuario.sobrenome,usuario.imagem
			FROM usuario 
			INNER JOIN grupo_has_usuario 
			ON usuario.id_usuario=grupo_has_usuario.usuario_id_usuario
			WHERE grupo_has_usuario.grupo_id_grupo=$grupo->id_grupo";
			$query  = mysql_query($texto,$con);
			
			$usuarios = array();
			while($linha = mysql_fetch_array($query)){
				$usuario = new Usuario();
				$usuario -> id_usuario = $linha['id_usuario'];
				$usuario -> nome = $linha['nome'];
				$usuario -> sobrenome = $linha['sobrenome'];
				$usuario -> imagem = $linha['imagem'];
				array_push($usuarios,$usuario);
			}				
			return $usuarios;
		}
		
		public function verificarParticipacaoGrupo($usuario){
			$con = self::conexao();
			
			$texto = "SELECT usuario_id_usuario 
			FROM grupo_has_usuario
			WHERE grupo_id_grupo = $this->id_grupo 
			AND usuario_id_usuario = $usuario->id_usuario";
			
			$query  = mysql_query($texto,$con);
			
			if(mysql_num_rows($query)>0){
				return true;
			} else {
				return false;
			}
		}	
	}		
?>