$(document).ready(function(){
	var senha = $("#senhaAntiga").val();

	$("#senhaAntiga").on("keyup", function(e){
		e.preventDefault();
		$.ajax({
			data: {'senha':senha},
			method: 'post',
			url: 'funcoes/verificaSenha.php',
			dataType: 'json',
			success: function(s){
				if($.isNumeric(s)){
					$("#buttonMudar").removeAttr('disabled');
				}else{
					$("#msgError").text(s);
					$("#buttonMudar").attr('disabled', 'disabled');
				}
				alert(s);
			}
		})
	})
})