$(document).ready(function(){
	$("#email").focus();
	//verifica quando o usuario clicar o botao para voltar ao formulario de cadastro
	$("#button_cadastrar").on("click", function(e){
		e.preventDefault();
		$("#login").toggleClass("active_form");
		$("#cadastro").toggleClass("active_form");
		$("#nome").focus();
		$("input").val('');
	})
	//verifica quando o usuario clicar o botao para voltar ao formulario de login
	$("#button_login").on("click", function(e){
		e.preventDefault();
		$("#login").toggleClass("active_form");
		$("#cadastro").toggleClass("active_form");
		$("#email").focus();
		$("input").val('');
	})
	//faz a verificação se as senhas digitadas são iguais
	$("#resenha").on("keyup", function(){
		if($(this).val() != $("#senha_c").val()){
			$("#btn_cadastro").attr("disabled", "disabled");
			$("#msg-error-senha").text("Senha não coincidem.");
		}else{
			$("#msg-error-senha").text("");
			$("#btn_cadastro").removeAttr("disabled");
		}
	})
})