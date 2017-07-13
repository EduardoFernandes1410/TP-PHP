(function () {
	var app = angular.module('main', ['ngRoute']);

//**********Routes**********//
	//Middleware
	app.run(['$rootScope', '$location', function($rootScope, $location,) {
		$rootScope.$on('$routeChangeStart', function(event, next, current) {
			console.log(next);
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

//**********Controladores*********//
	//Route Controller
	app.controller('RouteController', function($scope, $location) {
		$scope.$location = $location;
	});

	//Criar Eventos Controller
	app.controller("CriarAulaController", ['$timeout', function($timeout) {
		$timeout(function() {
			$(document).ready(function() {
				$('select').material_select();
			});
		});
	}]);
})();