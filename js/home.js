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

	$('.cep').mask('00000-000');
});