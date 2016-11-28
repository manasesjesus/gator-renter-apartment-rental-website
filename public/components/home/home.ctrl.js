app.controller('homeController', ['$location', '$scope', '$rootScope', 'store', 'Apartment', 'Upload', function($location, $scope, $rootScope, store, Apartment, Upload) {

	$scope.showPreloader = true;

    Apartment.query().$promise.then(function(data) {
    	$scope.showPreloader = false;
    	$scope.originalApartments = data;
    	$scope.apartments = $scope.originalApartments;
    });

    $rootScope.newApt = {};
    $rootScope.errorFields = undefined;

	$rootScope.showLogin = false;
	$rootScope.showSignup = false;
	$rootScope.showPost = false;

	$scope.propertyName = 'id';
	$scope.reverse = true;

	$scope.view = 'list';

	$scope.privateRoom = false;
	$scope.privateBath = false;
	$scope.kitchenIn = false;
	$scope.noDeposit = false;
	$scope.noCredit = false;

	/* Methods */

	$rootScope.login = function() {
		var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(regex.test($rootScope.username) && $rootScope.username == 'alex@gmail.com') {
			store.set('profile', { username: $rootScope.username, user_id: 1 });
			$rootScope.loginMessage = '';
			$rootScope.showLogin = false;
		} else {
			$rootScope.loginMessage = 'Please provide valid email address';
		}
	};

	$rootScope.logout = function() {
		store.remove('profile');
		$scope.go('/');
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

	$rootScope.applyNow = function() {
		if($rootScope.isAuthenticated()) {
			$rootScope.showApplyNow = true;
		} else {
			$rootScope.loginMessage = 'Please sign in to apply!'
			$rootScope.showLogin = true;
		}
	};

	$rootScope.savePost = function() {
		$rootScope.newApt['owner_id'] = store.get('profile')['user_id'];
		Apartment.save($rootScope.newApt, function(data) {
			$rootScope.showPost = false;
			$rootScope.newApt = {};
			$scope.apartments.push(data);
	    }, function(data) {
	    	$rootScope.errorFields = data.data.error;
	    });
	};

	$scope.uploadPic = function(file) {
		file.upload = Upload.upload({
			url: '/api/upload',
			data: { file: file }
		});
		file.upload.then(function(response) {
			file.result = response.data;
			if($rootScope.newApt.pictures == undefined) {
				$rootScope.newApt.pictures = response.data.files;
			} else {
				$rootScope.newApt.pictures.push(response.data.files);
			}
		}, function(response) {
			if(response.status > 0) {
				$scope.errorMsg = response.status + ': ' + response.data;
			}
			}, function(evt) {
				file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
			}
		);
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
