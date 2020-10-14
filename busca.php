<?php	
	require_once 'class/usuario.class.php';
	require_once 'action/comuns.action.php';
	include("header.php");
	if(isset($_SESSION['user_id'])){
		header('location:home.php');
	}
	
	$string_busca = strip_tags(addslashes($_POST['string_busca']));
?>
			<?php
				if($string_busca=="") {
					echo "Por favor, insira uma consulta na caixa de pesquisa.";
				} else {
					
					$usuario = new Usuario();
					$busca = Usuario::buscarConteudo($string_busca);
					
					foreach($busca as $item){
			?>
						<div style="float:left">
							<a href="usuario.php?id=<?php echo $item->id_item;?>">
								<img id='imagem_perfil' src="timthumb.php?src=<?php echo $servidor.$item->imagem_item;?>&h=150&w=150"/>
								<br />
								<span><?php echo $item->nome_item;?></span>
								<br />
								<span><?php echo $item->tipo_item;?></span>								
							</a>
						</div>
			<?php	
					}
				}
			?>
<?php include("footer.php"); ?>