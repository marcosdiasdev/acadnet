<?php
	class Busca {
		public $id_item;
		public $nome_item;
		public $imagem_item;
		public $tipo_item;
		
		public function __construct($id_item,$nome_item,$imagem_item,$tipo_item){
        	$this->id_item = $id_item;
        	$this->nome_item = $nome_item;
        	$this->imagem_item = $imagem_item;
        	$this->tipo_item = $tipo_item;
    	}
	}	
?>