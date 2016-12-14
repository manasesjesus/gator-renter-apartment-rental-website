<!-- Created by SFSU             -->
app.controller('apartmentController', ['$scope', '$routeParams', 'Apartment', 'NgMap', function($scope, $routeParams, Apartment, NgMap) {
	
	Apartment.get({ id: $routeParams['apartment_id'] }).$promise.then(function(data) {
		$scope.apartment = data;
	});
	
	$scope.showApplyNow = false;

}]);