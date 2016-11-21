app.controller('homeController', ['$location', '$scope', '$rootScope', 'store', 'Apartment', function($location, $scope, $rootScope, store, Apartment) {

    Apartment.query().$promise.then(function(data) {
    	$scope.originalApartments = data;
    	$scope.apartments = $scope.originalApartments;
    });

	$rootScope.showLogin = false;
	$rootScope.showSignup = false;
	$rootScope.showPost = false;

	$scope.propertyName = 'title';
	$scope.reverse = true;

	$scope.view = 'list';

	$scope.privateRoom = false;
	$scope.privateBath = false;
	$scope.kitchenIn = false;
	$scope.noDeposit = false;
	$scope.noCredit = false;

	/* Methods */

	$rootScope.login = function() {
		// login the user with $rootScope.username and $rootScope.password
		store.set('profile', { username: $rootScope.username });
		$rootScope.loginMessage = '';
		$rootScope.showLogin = false;
	};

	$rootScope.signup = function() {
		// signup the user with $rootScope.username and $rootScope.password
		store.set('profile', { username: $rootScope.username });
		$rootScope.loginMessage = '';
		$rootScope.showSignup = false;
	};

	$rootScope.logout = function() {
		store.remove('profile');
	};

	$rootScope.isAuthenticated = function() {
		return store.get('profile') != null;
	};

	$rootScope.getEmail = function() {
		return store.get('profile') != null ? store.get('profile')['username'] : '';
	};

	$rootScope.postApartment = function() {
		if($rootScope.isAuthenticated()) {
			$rootScope.showPost = true;
		} else {
			$rootScope.loginMessage = 'Please sign in to post an apartment!'
			$rootScope.showLogin = true;
		}
	};

	$scope.update = function() {
		if($scope.minPrice == '') $scope.minPrice = undefined;
		if($scope.maxPrice == '') $scope.maxPrice = undefined;
		if($scope.minPrice == undefined && $scope.maxPrice == undefined) {
			$scope.apartments = $scope.originalApartments;	
		} else {
			$scope.apartments = [];
			if($scope.minPrice == undefined && $scope.maxPrice != undefined) {
				var min = 0;
				var max = parseFloat($scope.maxPrice);
			} else if($scope.minPrice != undefined && $scope.maxPrice == undefined) {
				var min = parseFloat($scope.minPrice);
				var max = 100000;
			} else {
				var min = parseFloat($scope.minPrice);
				var max = parseFloat($scope.maxPrice);
			}
			angular.forEach($scope.originalApartments, function(apartment, key) {
				if(apartment.monthly_rent >= min && apartment.monthly_rent <= max) {
					$scope.apartments.push(apartment);
				}
			});
		}
	};

	$scope.sortBy = function(propertyName) {
		$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
		$scope.propertyName = propertyName;
	};

	$scope.go = function(path) {
		$location.path(path);
	};





}]);
