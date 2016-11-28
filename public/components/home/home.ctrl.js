app.controller('homeController', ['$location', '$scope', '$rootScope', 'store', 'Apartment', 'Upload', '$http', function($location, $scope, $rootScope, store, Apartment, Upload, $http) {

    Apartment.query().$promise.then(function(data) {
    	$scope.originalApartments = data;
    	$scope.apartments = $scope.originalApartments;
    });

    $rootScope.newApt = {};
    $rootScope.errorFields = undefined;

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
		var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if (regex.test($rootScope.username) && $rootScope.hasValidData($rootScope.password, 1)) {
            $http.get('api/login?loginname=' + $rootScope.username + '&password=' + $rootScope.password)
                .then(function successCallback(response) {
                    if (response.data.first_name) {
                        store.set('profile', {username: $rootScope.username, user_id: response.data.uid});
                        $rootScope.loginMessage = '';
                        $rootScope.showLogin = false;
                    }
                    else {
                        $rootScope.loginMessage = 'email or password incorrect';
                    }
            }, function errorCallback(response) {
                $rootScope.loginMessage = 'Error: ' + response;
            });
		} else {
			$rootScope.loginMessage = 'email or password incorrect';
		}
	};

	$rootScope.logout = function() {
        store.remove('profile');
        $rootScope.first_name = "";
        $rootScope.last_name = "";
        $rootScope.username = "";
        $rootScope.password = "";
        $rootScope.address = "";
        $scope.go('/');
	};

	$rootScope.signup = function() {
        var errors = "";
        var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        $rootScope.errorFields = undefined;
        if (regex.test($rootScope.username)) {
            // Name validations, e.g. Xi Li (China)
            if (!$rootScope.hasValidData($rootScope.first_name, 2)) { errors += "first_name, "; }
            if (!$rootScope.hasValidData($rootScope.last_name, 2))  { errors += "last_name, "; }
            // Simple password, not strict
            if (!$rootScope.hasValidData($rootScope.password, 1))   { errors += "password"; }

            if (errors.length == 0) {
                $http({
                    method: 'POST',
                    url: 'api/Users',
                    data: {
                        first_name: $rootScope.first_name,
                        last_name: $rootScope.last_name,
                        email: $rootScope.username,
                        password: $rootScope.password,
                        address: $rootScope.address,
                        city: $rootScope.city,
                        role_type_id: "2"
                    }
                }).then(function successCallback(response) {
                    store.set('profile', {username: $rootScope.username, user_id: response.data.data.user_id});
                    $rootScope.loginMessage = '';
                    $rootScope.showSignup = false;
                }, function errorCallback(response) {
                    $rootScope.loginMessage = 'Error: ' + response;
                });
            }
            else {
                $rootScope.errorFields = errors;
                $rootScope.loginMessage = 'Please provide all required fields';
            }
        } else {
            $rootScope.errorFields = "username";
            $rootScope.loginMessage = 'Please provide a valid email address';
        }
	};

	$rootScope.hasValidData = function (field, lng) {
        return (field && field.length >= lng);
    }

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
			url: 'api/upload',
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
