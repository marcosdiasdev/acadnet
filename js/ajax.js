// Retorna parâmetro da URL
function getUrlVar(key){
	var result = new RegExp(key + "=([^&]*)", "i").exec(window.location.search); 
	return result && result[1] || ""; 
}

function exibeConteudo(local,conteudo){
	$.get(conteudo,function(dados){
		$(local).html(dados);
	});
}

function exibeMinhasInformacoes(local,conteudo){
	$.get(conteudo,function(dados){
		var objeto = $.parseJSON(dados);
		$(local).html(objeto['dados']);
		$('#imagem_perfil').attr('src',objeto['imagem']);
	});
}

function exibeEditarInformacoes(local,conteudo){
	$('#container_editar_informacoes').fadeIn('fast');
	$('#fundo').fadeIn('fast');
	$('#subcontainer_editar_informacoes').fadeIn('fast',function(){
		$.get(conteudo,function(dados){
			$(local).html(dados);
			$('.fechar').click(function(){
				$('#container_editar_informacoes').fadeOut('fast');
				$('#fundo').fadeOut('fast');
				$('#subcontainer_editar_informacoes').fadeOut('fast');
			});
		});
	});
}

function validaLogin(){
	$.post('action/login.action.php', $('#login').serialize(), function(resposta) {
		resposta = $.trim(resposta);
				
		if (resposta) {
			alert('E-mail e/ou senha incorretos. Tente novamente.');
			$("#senha_login").val("");
		} 
		else {
			var url = "home.php";
			$(window.document.location).attr('href',url);
		}
	});
}

function exibeResponderRecado(idRecado){
	$('#subcontainer_responder_recado'+idRecado).toggle(200);
}

function enviaRecado(){	
	$.post('action/envia_recado.action.php', $('#envia_recado').serialize(), function(resposta){
		$("textarea[name=texto_recado]").val('');
		$('#container_postar_recados').after(resposta);
	});
}

function respondeRecado(formId){
	$.post('action/envia_recado.action.php', $('#envia_recado'+formId).serialize(), function(resposta){
		$("textarea[name=texto_recado]").val('');
		$('#subcontainer_responder_recado'+formId).toggle(200);
	});
}

function apagaRecado(idRecado,numMetodo){
	$.get("action/apaga_recado.action.php?id_recado="+idRecado+"&num_metodo="+numMetodo, function(){
		$("#container_recado"+idRecado).fadeOut('slow', function(){
			$("#container_recado"+idRecado).remove();
					if($(".container_recado").size() <= 0){  
						$("#container_recados").append("<div id='recados_aviso'><h3>Não há novos recados.</h3></div>");
					}
		});
	});
}

function validaCadastro(){
	var nome = $("input[name=nome]").val();
	var sobrenome = $("input[name=sobrenome]").val();
	var genero = $("select[name=genero]").val();
	var dia = $("select[name=dia]").val();
	var mes = $("select[name=mes]").val();
	var ano = $("select[name=ano]").val();
	var email = $("input[name=email]").val();
	var senha = $("input[name=senha]").val();
	
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

	$('.erro').hide();
	Erro = false;
	
	if(nome == ''){
		$("#nome_cadastro").after('<span class="erro"> Insira seu nome.</span>');
		Erro = true;
	}
	if(sobrenome == ''){
		$("#sobrenome_cadastro").after('<span class="erro"> Insira seu sobrenome.</span>');
		Erro = true;
	}
	if(genero == ''){
		$("#genero_cadastro").after('<span class="erro"> Insira seu gênero.</span>');
		Erro = true;
	}
	if(dia == '' || mes == '' || ano == ''){
		$("#nascimento_cadastro").after('<span class="erro"> Insira sua data de nascimento.</span>');
		Erro = true;
	}	
	if(email == '') {
		$("#email_cadastro").after('<span class="erro"> Insira seu endereço de e-mail.</span>');
		Erro = true;
	}
	else if(!emailReg.test(email)) {
		$("#email_cadastro").after('<span class="erro"> Insira um endereço de e-mail válido.</span>');
		Erro = true;
	}	
	if(senha == '') {
		$("#senha_cadastro").after('<span class="erro"> Insira uma senha.</span>');
		Erro = true;
	}
	if(Erro == false){	
		$.post('action/cadastro.action.php', $('#cadastro').serialize(), function(resposta) {
			resposta = $.trim(resposta);
			if (resposta == '1') {
				alert('Não foi possível realizar seu cadastro. Tente novamente mais tarde.');
			} else if (resposta == '2') {
				$("#email_cadastro").after('<span class="erro"> Endereço de e-mail indisponível.</span>');
			} else {
				var url = "home.php";
				$(window.document.location).attr('href',url);
			}
		});
	}
}

function adicionaAmigo(idAmigo){
	$.get('action/adiciona_amigo.action.php?id_amigo='+idAmigo,function(resultado){
		$('#adiciona').fadeOut('slow');
	});
		
}

function excluiAmigo(idAmigo){
	$.get('action/exclui_amigo.action.php?id_amigo='+idAmigo);
	$('#exclui').fadeOut('slow');	
}

function aceitaAdicionaAmigo(idAmigo,numNotificacao){
	$.get("action/aceita_adiciona_amigo.action.php?id_amigo="+idAmigo, function(){
		$('#notificacao'+numNotificacao).fadeOut('slow');
	});
}

function rejeitaAdicionaAmigo(idAmigo,numNotificacao){
	$.get("action/rejeita_adiciona_amigo.action.php?id_amigo="+idAmigo, function(resposta){
		$('#notificacao'+numNotificacao).fadeOut('slow');
	});
}

function atualizaInformacoesPessoais(){
	$.post("action/altera_informacoes.action.php", $('#info_pessoais').serialize(), function(){
		location.reload();
	});
}

function alteraStatus(){
	$('#status').fadeOut('fast',function(){
		$.post("action/altera_status.action.php", $('#formStatus').serialize(), function(status){
			$('#status_campo').val('');
			$('#status').fadeIn('fast',function(){
				$('#status').html(status);
			});	
		});
	});
}

function validaAlteraSenha(){
	var senha1 = $("input[name=senha1]").val();
	var senha2 = $("input[name=senha2]").val();
	
	$('.erro').hide();
	Erro = false;

	$('input').focus(function(){
		$('.erro').fadeOut();
	});
	
	if(senha1 != senha2){
		$("input[name=senha2]").after('<span class="erro">As senhas digitadas não coincidem.</span>');
		Erro = true;
	}
	if(Erro == false){	
		$.post('action/altera_senha.action.php', $('form').serialize(), function(resposta) {
			if (resposta == '0') {
				alert('Não foi possível modificar a sua senha. Tente novamente.');
			} else if (resposta == '1')  {
				alert('Senha alterada. Você será redirecionado.');
				var url = "index.php";
				$(window.document.location).attr('href',url);
			}
		});
	}
}

function exibeCriaGrupo(local,conteudo){
	$(local).fadeIn('fast',function(){
		$.get(conteudo,function(dados){
			$(local).html(dados);
			$('.fechar').click(function(){
				$(local).fadeOut('fast');
			});
		});
	});
}

function exibeEditaGrupo(local,conteudo,id){
	$(local).fadeIn('fast',function(){
		$.get(conteudo,function(dados){
			$(local).html(dados);
			$('#grupo_id_campo').attr('value',id);
			$('.fechar').click(function(){
				$(local).fadeOut('fast');
			});
		});
	});
}

function criaTopico(){
	$.post('action/cria_topico.action.php', $('#cria_topico').serialize(), function(resposta){
		$("textarea[name=conteudo_topico]").val('');
		//var idGrupo = $("input[name=id_usuario]").val();
		//exibeConteudo('#container_conteudo_grupo','grupo.conteudo.php?id='+idGrupo);		
	});
}

function criaComentario(id_topico){
	$.post('action/cria_comentario.action.php', $('#cria_comentario'+id_topico).serialize(), function(resposta){
//		$("textarea[name=conteudo_comentario]").val('');
	//	var idGrupo = $("input[name=id_usuario]").val();
		//exibeConteudo('#container_conteudo_grupo','grupo.conteudo.php?id='+idGrupo);		
	});
}

$(function() {
	$('textarea').elastic();
});

function enviaEmailAlteraSenha(){
	var email = $("input[name=email]").val();
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	
	$('.erro').hide();
	Erro = false;

	$('input').focus(function(){
		$('.erro').fadeOut();
	});
	
	if(email == ''){
		$("#enviar").after('<span class="erro">Preencha o campo de e-mail.</span>');
		Erro = true;
	} else if(!emailReg.test(email)) {
		$("#enviar").after('<span class="erro"> Insira um endereço de e-mail válido.</span>');
		Erro = true;
	}	
	
	if(Erro == false){	
		$.post('action/esqueceu_a_senha.action.php', $('form').serialize(), function(resposta) {
			alert(resposta);
			var url = "index.php";
			$(window.document.location).attr('href',url);
		});
	}
}

function excluirConta(){
	var senha = $("input[name=senha]").val();
		
	$('.erro').hide();
	Erro = false;

	$('input').focus(function(){
		$('.erro').fadeOut();
	});
	
	if(senha == ''){
		$("#enviar").after('<span class="erro">Digite uma senha!</span>');
		Erro = true;
	}
	
	if(Erro == false){
		$.post('action/excluir_conta.action.php', $('form').serialize(), function(resposta) {
			if(resposta){
				alert('Sua conta foi excluída. Você será redirecionado.');
				var url = "index.php";
				$(window.document.location).attr('href',url);
			} else {
				$("#enviar").after('<span class="erro">Dados incorretos.</span>');				
			}
		});
	}
}