<?php
	require_once '../class/usuario.class.php';
	require_once 'comuns.action.php';
	
	$usuario = new Usuario();
	$usuario->email = strip_tags(addslashes($_POST['email']));
	
	// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
	include("../phpmailer/class.phpmailer.php");
	include("../phpmailer/class.smtp.php");
	include("../phpmailer/class.pop3.php");
	
	//Ativa o debug
	//$mail->SMTPDebug = true;
	
	$email_servidor = "ti.marcosdias@gmail.com";
	$senha_servidor  = "unplugged@19993602";
	
	//Instancia um objeto da classe PHPMailer
	$mail = new PHPMailer;
	
	//Inicia
	$mail->IsHTML(true);
	//Informa que ser� utilizado o SMTP para envio do e-mail
	$mail->IsSMTP();
	//Informa que a conex�o com o SMTP ser� aut�nticado
	$mail->SMTPAuth   = true;
	//Configura��o de HOST do SMTP
	$mail->Host       = "smtp.gmail.com"; //Verifique qual o SMTP do seu dom�nio
	//Usu�rio para aut�ntica��o do SMTP
	$mail->Username =   $email_servidor; //E-mail do servidor
	//Senha para aut�ntica��o do SMTP
	$mail->Password =   $senha_servidor; //Senha do servidor
	//Titulo do e-mail que ser� enviado
	$mail->Subject  =   "Formulário de contato";
	
	//Preenchimento do campo FROM do e-mail
	$mail->From = $mail->Username;
	$mail->FromName = "Suporte Acadnet";
	
	//E-mail para a qual o e-mail ser� enviado
	$mail->AddAddress($usuario->email);
	
	//Gera c�digo de redefinição de senha
	
	$codigo = $usuario->gerarCodigoRedefinicaoSenha();
	
	//Gera conteúdo do e-mail
	$conteudo_email = 
	"Olá, " . $usuario->email . ". Segue abaixo o link para redefinição de senha.
	<br />
	<br />
	".$servidor."altera_senha.php?codigo=".$codigo."&email=".$usuario->email;
	$mail->Body = $conteudo_email;
	$mail->AltBody = $mail->Body;
	
	//Dispara o e-mail
	$enviado = $mail->Send();
	
	//Imprime sucesso.
	if($enviado){ 
		echo "Um e-mail com instruções para a recuperação da sua senha foi enviado para ".$usuario->email.".";
	}else{
		echo "Um erro ocorreu durante a tentativa de envio. Tente novamente.";
	}
?>