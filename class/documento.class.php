<?php
	require_once 'principal.class.php';
	
	class Documento extends Principal {
		public $id_documento;
		public $titulo;
		public $descricao;
		public $autor;
		public $data;
		public $caminho;
		public $arquivo;
		
		static function exibirDocumentos($id_usuario){
			$con = self::conexao();
			
			$texto = "SELECT * FROM documento WHERE usuario_id_usuario = $id_usuario";
			$resultado  = mysql_query($texto,$con);
			
			$documentos = array();
			while($linha = mysql_fetch_array($resultado)){
				$documento = new Documento();
				$documento -> id_documento = $linha['id_documento'];
				$documento -> titulo = $linha['titulo'];
				$documento -> descricao = $linha['descricao'];
				$documento -> autor = $linha['usuario_id_usuario'];
				$documento -> caminho = $linha['caminho'];
				array_push($documentos,$documento);
			}				
			return $documentos;
		}
	}	
?>