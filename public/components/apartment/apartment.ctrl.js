app.controller('apartmentController', ['$scope', '$routeParams', 'Apartment', function($scope, $routeParams, Apartment) {
	
	Apartment.get({ apartment_id: $routeParams['apartment_id'] }).$promise.then(function(data) {
		$scope.apartment = data;
	});
	
}]);