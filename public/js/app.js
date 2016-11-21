var app = angular.module('gatorRenter', [
	'ngRoute',
	'ngResource',
	'ngMap',
	'angular-storage'
]);

app.config(['$locationProvider', '$routeProvider', '$httpProvider', function($locationProvider, $routeProvider, $httpProvider) {

	$routeProvider.when('/', {
		controller: 'homeController',
		templateUrl: 'components/home/home.html'
	}).when('/apartment/:apartment_id', {
		controller: 'apartmentController',
		templateUrl: 'components/apartment/apartment.html'
	}).when('/profile', {
		controller: 'homeController',
		templateUrl: 'components/profile/profile.html'
	});

}]);

app.filter('customFilter', function() {
	return function (items, privateRoom, privateBath, kitchenIn, noDeposit, noCredit) {
		if(items != undefined) {
			var filtered = [];
		   	for(var i = 0; i < items.length; i++) {
				var item = items[i];
				if( (item.private_room == true || item.private_room == privateRoom) &&
					(item.private_bath == true || item.private_bath == privateBath) &&
					(item.kitchen_in_apartment == true || item.kitchen_in_apartment == kitchenIn) &&
					(item.has_security_deposit == false || item.has_security_deposit != noDeposit) &&
					(item.credit_score_check == false || item.credit_score_check == noCredit)) {
					filtered.push(item);
				}
		    }
		    return filtered;
		} else {
			return items;
		}
	};
});
