<?php
	require_once 'principal.class.php';
	
	class Topico extends Principal {
		public $id_topico;
		public $conteudo_topico;
		public $data_topico;
		public $usuario_id_usuario;
		public $grupo_id_grupo;
		
		public $id_usuario;
		public $nome;
		public $sobrenome;
		public $imagem;
	
		static function exibirTopicos($grupo){
			$con = self::conexao();
		
			$texto = "SELECT 
			usuario.id_usuario,usuario.nome,usuario.sobrenome,usuario.imagem,
			topico.id_topico,topico.conteudo_topico,topico.data_topico
			FROM usuario
			INNER JOIN topico
			ON usuario.id_usuario=topico.usuario_id_usuario
			WHERE topico.grupo_id_grupo = $grupo->id_grupo
			ORDER BY id_topico DESC";

			$query = mysql_query($texto,$con) or die("Erro ao selecionar");
			
			if(mysql_num_rows($query)>0){
				$topicos = array();
				while($linha = mysql_fetch_array($query)){		
					$topico = new Topico();
					$topico -> id_topico = $linha['id_topico'];
					$topico -> conteudo_topico = $linha['conteudo_topico'];
					
					$topico -> data_topico = $linha['data_topico'];
					$date = array();
					$date = explode(' ', $topico -> data_topico);
					$topico -> data_topico = explode('-', $date[0]);
					$topico -> data_topico = 'Em '.$topico -> data_topico[2] .'/'. $topico -> data_topico[1] .'/'. $topico -> data_topico[0].' às '.$date[1];
					
					$topico -> id_usuario = $linha['id_usuario'];
					$topico -> nome = $linha['nome'];
					$topico -> sobrenome = $linha['sobrenome'];
					$topico -> imagem = $linha['imagem'];
					array_push($topicos,$topico);
				}	
			}else{
				$topicos = 0;
			}
			return $topicos;
		}
}
?>		