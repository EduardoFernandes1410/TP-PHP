$(document).ready(function(){
	$('.collapsible').collapsible();

	$(".button-collapse").sideNav({
		edge: 'left',
		closeOnClick: true,
		draggable: false,
	});

	/**********VIRAR SENSEI**********/
	$('.modal').modal();

	// Comandos do JQuery Mask Plugin: http://igorescobar.github.io/jQuery-Mask-Plugin/
	$('.cpf').mask('000.000.000-00', {
		reverse: false
	});

	$('.phone_with_ddd').mask('+00 (00) 00000-0000');
});

function logout() {
	firebase.auth().signOut().then(function() {
		//Tira do SESSION
		$.ajax({
			url: window.location.href = window.location.href.split("/")[0] + "/backend/user/logout.php",
			method: 'GET',
			data: null,
			success: function(asnwer) {
				// console.log("SUCESSO");
				window.location.href = window.location.href.split("/")[0] + "/html/login.html";
			}
		});
		
	}, function(error) {
		//Deu ruim
	});
}