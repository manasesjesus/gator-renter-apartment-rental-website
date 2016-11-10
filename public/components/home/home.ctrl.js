app.controller('homeController', ['$location', '$scope', '$rootScope', 'Apartment', function($location, $scope, $rootScope, Apartment) {

    Apartment.query().$promise.then(function(data) {
    	$scope.apartments = data;
    });

	$rootScope.showLogin = false;
	$rootScope.showSignup = false;

	$scope.propertyName = 'title';
	$scope.reverse = true;

	$scope.view = 'list';

	$scope.privateRoom = false;
	$scope.privateBath = false;
	$scope.kitchenIn = false;
	$scope.noDeposit = false;
	$scope.noCredit = false;

	/* Methods */

	$scope.sortBy = function(propertyName) {
		$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
		$scope.propertyName = propertyName;
	};

	$scope.go = function(path) {
		$location.path(path);
	};

}]);