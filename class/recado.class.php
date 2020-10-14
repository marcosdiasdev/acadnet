<?php
	require_once 'principal.class.php';
	
	class Recado extends Principal {
		public $id_recado;
		public $usuario_id_usuario;
		public $usuario_id_remetente;
		public $texto_recado;
		public $data_recado;
		public $hora_recado;
		public $imagem_remetente;
		public $nome_remetente;
		public $sobrenome_remetente;
		
		static function exibirRecados($usuario){
			$con = self::conexao();
			
			$texto = "SELECT 
			usuario.imagem,usuario.nome,usuario.sobrenome,
			recado.id_recado,recado.usuario_id_usuario,recado.usuario_id_remetente,
			recado.texto_recado,recado.data_recado
			FROM recado
			INNER JOIN usuario
			ON recado.usuario_id_remetente=usuario.id_usuario
			WHERE recado.usuario_id_usuario = $usuario->id_usuario
			ORDER BY recado.id_recado DESC";
			
			$resultado  = mysql_query($texto,$con);
			
			if(mysql_num_rows($resultado)>0 ){
	
				$recados = array();
				
				while($linha = mysql_fetch_array($resultado)){
					
					$recado = new Recado();
					
					$recado->id_recado = $linha['id_recado'];
					$recado->id_usuario = $linha['usuario_id_usuario'];
					$recado->id_remetente = $linha['usuario_id_remetente'];
					$recado->imagem_remetente = $linha['imagem'];
					$recado->nome_remetente = $linha['nome'];
					$recado->sobrenome_remetente = $linha['sobrenome'];
					$recado->texto_recado = $linha['texto_recado'];
					$recado->data_recado = $linha['data_recado'];
					
					$date = array();
					
					$date = explode(' ', $recado -> data_recado);
					$recado->data_recado = $date[0];
					$recado->data_recado = explode('-', $recado -> data_recado);
					$recado->data_recado = $recado -> data_recado[2] .'/'. $recado -> data_recado[1] .'/'. $recado -> data_recado[0];
					$recado->hora_recado = $date[1];
					
					array_push($recados,$recado);
				}
			}else{
				$recados = 0;
			}
			return $recados;
		}
	}
?>