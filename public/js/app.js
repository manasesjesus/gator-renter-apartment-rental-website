var app = angular.module('gatorRenter', [
	'ngRoute',
	'ngResource'
]);

app.config(['$locationProvider', '$routeProvider', '$httpProvider', function($locationProvider, $routeProvider, $httpProvider) {

	$routeProvider.when('/', {
		controller: 'homeController',
		templateUrl: 'components/home/home.html'
	}).when('/apartment/:apartment_id', {
		controller: 'apartmentController',
		templateUrl: 'components/apartment/apartment.html'
	});

}]);