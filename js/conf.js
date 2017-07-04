$(document).ready(function(){
	$('.collapsible').collapsible();

	$(".button-collapse").sideNav({
		edge: 'right'
	});
	
	$(".dropdown-button").dropdown();
	$('.dropdown-button').dropdown('close');
	
	$("#dropdown1").dropdown({
		belowOrigin: true
	});
	$("#dropdown2").dropdown({
		belowOrigin: true
	});
});