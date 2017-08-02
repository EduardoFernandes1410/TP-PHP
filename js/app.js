(function () {
	var app = angular.module('main', ['ngRoute']);

//**********Routes**********//
	//Middleware
	app.run(['$rootScope', '$location', function($rootScope, $location,) {
		$rootScope.$on('$routeChangeStart', function(event, next, current) {
			//Se for pra MAIN-PAGE
			if(!next.templateUrl) {
				$location.path('/');
			} else if(next.templateUrl == "../html/create-class.html") {
				$location.path('/create-class');
			}
		});
	}]);

	//Navegacao
	app.config(function($routeProvider) {
		$routeProvider
		.when("/create-class",
			{
				templateUrl: "../html/create-class.html",
				controller: "CriarAulaController"
			}
		)
		.otherwise(
			{
				redirectTo: "/"
			}
		);
	});
	
//**********Services*********//
	//Criar Aula Service
	app.factory('CriarAulaService', function($http) {
		var criarAulaService = {};

		//POST /criar-evento
		criarAulaService.postCriarAula = function(data, callback) {
			$http.post('../backend/aulas/cadastra.php', data).then(function successCallback(response) {
				//Sucesso
				var answer = response.data;
				callback(answer);
			}, function errorCallback(response) {

			});
		}

		return criarAulaService;
	});

//**********Controladores*********//
	//Route Controller
	app.controller('RouteController', function($scope, $location) {
		$scope.$location = $location;
	});

	//Criar Eventos Controller
	app.controller("CriarAulaController", ['CriarAulaService', '$timeout', '$scope', '$route', function(criarAulaService, $timeout, $scope, $route) {
		$timeout(function() {
			//Inicia elementos do Materialize
			$(document).ready(function() {				
				//Date-Picker
				$('.datepicker').pickadate({
					monthsFull: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
					monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
					weekdaysFull: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
					weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
					today: 'Hoje',
					clear: 'Limpar',
					close: 'Pronto',
					labelMonthNext: 'Próximo mês',
					labelMonthPrev: 'Mês anterior',
					labelMonthSelect: 'Selecione um mês',
					labelYearSelect: 'Selecione um ano',
					selectMonths: true,
					selectYears: 2,
					format: 'dd/mm/yyyy'
				});
				
				//Time-Picker
				$('.timepicker').pickatime({
					default: 'now', // Set default time
					fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
					twelvehour: false, // Use AM/PM or 24-hour format
					donetext: 'OK', // text for done-button
					cleartext: 'Limpar', // text for clear-button
					canceltext: 'Cancelar', // Text for cancel-button
					autoclose: false, // automatic close timepicker
					ampmclickable: true, // make AM PM clickable
					aftershow: function(){} //Function for after opening timepicker  
				});
			});
		});
		
		$scope.criarAula = function(params) {
			//Pega as tags marcadas
			var tags = $("input[name='tags[]']:checked").toArray();
			var tagsArray = [];
						
			tags.forEach(elem => tagsArray.push(elem.value));
			
			//Pega a data
			var dataCompleta = params.Data.split("/").reverse().join("-");
			dataCompleta += 'T' + params.Horario + ":00";
			dataCompleta = new Date(dataCompleta).toUTCString().replace(" GMT", "");
			
			//Monta objeto de POST
			var dataPost = {
				nome: params.Nome,
				sensei: 'Eduardo',
				preco: params.Preco,
				tags: tagsArray,
				local: params.Local,
				data: dataCompleta,
				capacidade: 1
			};
			
			//Faz o POST
			criarAulaService.postCriarAula(dataPost, function(answer) {
				//Emite alerta sobre o status da operacao e redireciona
				if(answer) {
					Materialize.toast("Aula criada com sucesso!", 3000);
					$location.path('/');
					$route.reload();
				} else {
					Materialize.toast("Erro ao criar a aula!", 3000);
				}
			});
		}
	}]);
})();