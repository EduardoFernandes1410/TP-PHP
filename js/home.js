$(document).ready(function(){
	$('.collapsible').collapsible();

	$(".button-collapse").sideNav({
		edge: 'left'
	});

	$('.modal').modal();

	$('.cpf').mask('000.000.000-00', {
		reverse: false
	});
});