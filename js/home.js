$(document).ready(function(){
	$('.collapsible').collapsible();

	$(".button-collapse").sideNav({
		edge: 'left'
	});

	$('.modal').modal();

	// Comandos do JQuery Mask Plugin: http://igorescobar.github.io/jQuery-Mask-Plugin/

	$('.cpf').mask('000.000.000-00', {
		reverse: false
	});

	$('.phone_with_ddd').mask('+00 (00) 00000-0000');
});

var enviaFormularioSensei = function(){
	var cadastroUsuario = {
		Cpf: document.getElementById('cpf').value,
		Fone: document.getElementById('contato').value,
		Cidade: document.getElementById('cidade').value,
		Rua: document.getElementById('rua').value,
		Numero: document.getElementById('numero').value,
		Complemento: document.getElementById('complemento').value
	};

	cadastroUsuario = JSON.stringify(cadastroUsuario);

	$.ajax({
		data: 'cadastroUsuario=' + cadastroUsuario,
		url: "../backend/user/virasensei.php",
		method: 'POST',
		success: function(){
			console.log("Cadastro enviado para o Developer Team!");
		},
		error: function(){
			console.log("Formulário inválido!");
		}
	});
}