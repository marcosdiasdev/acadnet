<?php
	require_once 'principal.class.php';
	
	class Comentario extends Principal {
		public $id_comentario;
		public $conteudo_comentario;
		public $data_comentario;
		public $topico_id_topico;
		public $grupo_id_grupo;
		
		public $id_usuario;
		public $nome;
		public $sobrenome;
		public $imagem;
		
		static function exibirComentarios($topico){
			$con = self::conexao();
		
			$texto = "SELECT 
			usuario.id_usuario,usuario.nome,usuario.sobrenome,usuario.imagem,
			comentario.id_comentario,comentario.conteudo_comentario,comentario.data_comentario
			FROM usuario
			INNER JOIN comentario
			ON usuario.id_usuario=comentario.usuario_id_usuario
			WHERE comentario.topico_id_topico = $topico->topico_id_topico
			ORDER BY id_comentario ASC";

			$query = mysql_query($texto,$con) or die("Erro ao selecionar");
			
			if(mysql_num_rows($query)>0){
				$comentarios = array();
				while($linha = mysql_fetch_array($query)){		
					$comentario = new comentario();
					$comentario -> id_comentario = $linha['id_comentario'];
					$comentario -> conteudo_comentario = $linha['conteudo_comentario'];
					$comentario -> data_comentario = $linha['data_comentario'];
					$comentario -> data_comentario = explode('-', $comentario -> data_comentario);
					$comentario -> data_comentario = $comentario -> data_comentario[2]. '/'.$comentario -> data_comentario[1]. '/'.$comentario -> data_comentario[0];
					$comentario -> id_usuario = $linha['id_usuario'];
					$comentario -> nome = $linha['nome'];
					$comentario -> sobrenome = $linha['sobrenome'];
					$comentario -> imagem = $linha['imagem'];
					array_push($comentarios,$comentario);
				}	
			}else{
				$comentarios = 0;
			}
			return $comentarios;
		}		
}
?>		