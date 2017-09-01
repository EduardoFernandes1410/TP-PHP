(function () {
	var app = angular.module('main', ['ngRoute']);

//**********Routes**********//
	//Middleware
	app.run(['HTTPService', '$rootScope', '$location', '$window', function(httpService, $rootScope, $location, $window) {
		$rootScope.$on('$routeChangeStart', function(event, next, current) {
			// Se tentar acessar sem estar logado
			httpService.get("../backend/utils/sessao.php", function(answer) {
				if(!answer) {
					//Redireciona para pagina de login
					if(next.templateUrl != "http://localhost:8080") {
						event.preventDefault();
						$window.location.replace('http://localhost:8080');
					}
				}
			});
		});
	}]);

	//Navegacao
	app.config(function($routeProvider) {
		$routeProvider
		.when("/aulas", 
			{
				templateUrl: "../html/aulas.html",
				controller: "ExibirAulaController",
				controllerAs: "Aula"
			}
		)
		.when("/create-class",
			{
				templateUrl: "../html/create-class.html",
				controller: "CriarAulaController"
			}
		)
		.when("minhas-aulas",
			{
				templateUrl: "../html/aulas.html",
				controller: "CriarAulaController"
			}
		)
		.when("/sensei",
			{				
				templateUrl: "../html/sensei.html",
				controller: "SenseiController",
				controllerAs: "Sensei"
			}
		)
		.otherwise(
			{
				redirectTo: "/aulas"
			}
		);
	});
	
//**********Services*********//
	app.factory('HTTPService', function($http) {
		var httpService = {};
		
		//POST
		httpService.post = function(urlPost, data, callback) {
			$http.post(urlPost, data).then(function successCallback(response) {
				//Sucesso
				var answer = response.data;
				callback(answer);
			}, function errorCallback(response) {
				//
			});
		}
		
		//GET
		httpService.get = function(urlGet, callback) {
			$http.post(urlGet).then(function successCallback(response) {
				//Sucesso
				var answer = response.data;
				callback(answer);
			}, function errorCallback(response) {
				//
			});
		}
		
		return httpService;
	});

	//Pegar Aulas Service
	app.factory('PegarAulasService', ['HTTPService', function(httpService) {
		var pegarAulasService = {};
		
		pegarAulasService.getAulas = function(endereco, data, callback) {
			var aulas;
			
			//Pega as aulas
			httpService.post(endereco, data, function(answer) {
				if(answer) {
					answer = answer.reverse();
					aulas = answer;
					
					//Mexe nas tags
					aulas.forEach(elem => elem.tags = elem.strTags.split(","));
					//Mexe na data
					aulas.forEach(function(elem) {
						var data = new Date(elem.data);
						elem.dataHora = (data.getHours() >= 10 ? data.getHours() : "0" + data.getHours()) + ":" + (data.getMinutes() >= 10 ? data.getMinutes() : "0" + data.getMinutes());
						elem.dataDia = data.getDate() >= 10 ? data.getDate() : "0" + data.getDate();
						elem.dataDia += "/" + ((data.getMonth() + 1) >= 10 ? (data.getMonth() + 1) : "0" + (data.getMonth() + 1));
						elem.dataDia += "/" + data.getFullYear();
					});
					
					callback(aulas);
				}
			});
		}

		return pegarAulasService;
	}]);

//**********Controladores*********//
	//Route Controller
	app.controller('RouteController', function($scope, $location) {
		$scope.$location = $location;
	});
	
	//Login Controller
	app.controller('LoginController', ['HTTPService', '$rootScope', function(httpService, $rootScope) {
		//Pega a info do cara logado via GET
		httpService.get("../backend/utils/sessao.php", function(answer) {
			$rootScope.usuario = answer;
		});
	}]);

	//VirarSensei Controller
	app.controller('VirarSenseiController', ['HTTPService', '$scope', function(httpService, $scope) {
		$scope.virarSensei = function(params) {
			//Monta objeto de POST
			var dataPost = params;
			
			//Averigua se ha campo vazio
			if(!dataPost || Object.keys(dataPost).length != 6 || Object.values(dataPost).some(dado => dado == "")) {
				Materialize.toast("Favor preencher todos os campos", 3000);
				return;
			} else {
				dataPost = JSON.stringify(dataPost);
			}
						
			//Faz o POST
			httpService.post('../backend/user/virasensei.php', dataPost, function(answer) {
				//Emite alerta sobre o status da operacao e redireciona
				if(answer == "2") {					
					Materialize.toast("Você já era um sensei!", 3000);
				} else if(answer == "1") {
					Materialize.toast("Parabéns, agora você é sensei!", 3000);
				} else {
					Materialize.toast("Erro ao virar sensei!", 3000);
				}
			});
		}
	}]);

	//Criar Aulas Controller
	app.controller("CriarAulaController", ['HTTPService', '$timeout', '$scope', '$route', '$location', '$rootScope', function(httpService, $timeout, $scope, $route, $location, $rootScope) {
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
				
				//Minha casa
				$("#casa").change(function() {
					if(this.checked) {
						$("#local").attr("disabled", true);
					} else {
						$("#local").attr("disabled", false);			
					}
				});
			});
		});
		
		//Funcao de Criar Aula
		$scope.criarAula = function(params) {
			var usuario = $rootScope.usuario;
			
			//Pega as tags marcadas
			var tags = $("input[name='tags[]']:checked").toArray();
			var tagsArray = [];
						
			tags.forEach(elem => tagsArray.push(elem.value));
			
			//Pega a data
			var dataCompleta = params.Data.split("/").reverse().join("-");
			dataCompleta += 'T' + params.Horario + ":00";
			dataCompleta = new Date(dataCompleta).toUTCString().replace(" GMT", "");
			
			//Pega o local
			var local;
			
			if($("#casa").is(":checked")) {
				local = usuario.Rua + ", " + usuario.Numero + ", " + usuario.Complemento + " - " + usuario.Cidade;
			} else {
				local = params.Local;
			}
			
			//Monta objeto de POST
			var dataPost = {
				nome: params.Nome,
				sensei: $rootScope.usuario.ID,
				preco: params.Preco,
				tags: tagsArray,
				local: local,
				data: dataCompleta,
				capacidade: params.Capacidade
			};
			
			dataPost = JSON.stringify(dataPost);

			//Faz o POST
			httpService.post('../backend/aulas/cadastra.php', dataPost, function(answer) {
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

	//Exibir Aula Controller
	app.controller('ExibirAulaController', ['HTTPService', 'PegarAulasService', '$scope', '$rootScope', '$location', function(httpService, pegarAulasService, $scope, $rootScope, $location) {
		var aulas;
		var data = {
			tag: $location.search().id
		}
		var endereco = ($location.search().id) ? "../backend/aulas/readTags.php" : "../backend/aulas/read.php";
		
		//Pega as aulas
		pegarAulasService.getAulas(endereco, data, function(answer) {
			this.aulas = answer;
		}.bind(this));

		//Pega as inscricoes em aulas do cara
		$scope.getAulasConfirmadas = function() {
			httpService.get("../backend/user/aulas.php", function(answer) {
				if(answer) {
					$rootScope.aulasConfirmadas = answer;
				}
			}.bind(this));
		}
		//Chama a funcao		
		$scope.getAulasConfirmadas();
		
		$scope.inscreverNaAula = function(id, aula) {
			var data = {
				user: id,
				aula: aula
			};
			
			httpService.post("../backend/aulas/inscricao.php", data, function(answer) {
				if(answer == 1) {
					Materialize.toast("Inscricao realizada com sucesso!", 3000);
					//Atualiza
					$scope.getAulasConfirmadas();
				} else if(answer == 0) {
					Materialize.toast("Falha ao realizar a inscrição!", 3000);
				} else if(answer == 2) {
					Materialize.toast("Você já esta cadastrado nessa aula!", 3000);					
				}
			});
		}
		
		$scope.desinscreverNaAula = function(id, aula) {
			var data = {
				user: id,
				aula: aula
			};
			
			httpService.post("../backend/aulas/desinscrever.php", data, function(answer) {
				console.log(answer);
				if(answer) {
					Materialize.toast("Inscricao cancelada com sucesso!", 3000);
					//Atualiza
					$scope.getAulasConfirmadas();
				} else {
					Materialize.toast("Falha ao cancelar a inscrição!", 3000);
				}
			});
		}
		
		$scope.avaliarAula = function(nota, user, sensei) {
			var data = {
				sensei: sensei,
				gafanhoto: user,
				nota: nota
			};
			
			httpService.post("../backend/aulas/avaliar.php", data, function(answer) {
				if(answer != 0) {
					Materialize.toast("Avaliação realizada com sucesso!", 3000);
				} else {
					Materialize.toast("Falha ao avaliar a aula!", 3000);
				}
			});
		}

		//Verifica se o cara ja se inscreveu na aula
		$scope.estaConfirmado = function(evento) {
			if(!$rootScope.aulasConfirmadas) {
				return false;
			} else {
				return $rootScope.aulasConfirmadas.some(elem => elem == evento);
			}
		}
	}]);
	
	//Sensei Controller
	app.controller('SenseiController', ['HTTPService', '$location', function(httpService, $location) {
		var sensei;
		var aulas;
		var data = {
			id: $location.search().id
		}
		
		//Pega a info do sensei POST
		httpService.post("../backend/sensei/read.php", data, function(answer) {
			this.sensei = answer[0];
		}.bind(this));
		
		//Pega as aulas do sensei POST
		httpService.post("../backend/sensei/aulas.php", data, function(answer) {
			answer = answer.reverse();
			this.aulas = answer;
			
			//Mexe nas tags
			this.aulas.forEach(elem => elem.tags = elem.strTags.split(","));
			//Mexe na data
			this.aulas.forEach(function(elem) {
				var data = new Date(elem.data);
				elem.dataHora = (data.getHours() >= 10 ? data.getHours() : "0" + data.getHours()) + ":" + (data.getMinutes() >= 10 ? data.getMinutes() : "0" + data.getMinutes());
				elem.dataDia = data.getDate() >= 10 ? data.getDate() : "0" + data.getDate();
				elem.dataDia += "/" + ((data.getMonth() + 1) >= 10 ? (data.getMonth() + 1) : "0" + (data.getMonth() + 1));
				elem.dataDia += "/" + data.getFullYear();
			});
		}.bind(this));
	}]);
})();