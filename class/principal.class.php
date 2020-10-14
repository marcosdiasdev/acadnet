<?php
	class Principal {
			
		protected static function conexao(){
			$con = mysql_pconnect("localhost","root","") or die("Não foi possível conectar-se ao banco de dados");
			mysql_select_db("acadnet", $con)or die("Não foi possível conectar-se ao banco de dados");
			mysql_query("SET NAMES utf8", $con);
			return $con;
		}

		protected static function excluirArquivo($arquivo){
			if(file_exists($arquivo)){ 
				unlink($arquivo);
				return true;
			} else {
				return false;
			}
		}
	}	
?>