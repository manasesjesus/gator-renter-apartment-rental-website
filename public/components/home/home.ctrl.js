/**
 * Created by SFSU
 * Main Controller
 *
 * Modified by:
 *  - Intesar Haider
 *  - Manasés Galindo
 *  - Anil Manzoor
 */
app.controller('homeController', ['$location', '$scope', '$rootScope', 'store', 'Apartment', 'Upload', '$http', 'GHelper', '$timeout',
            function ($location, $scope, $rootScope, store, Apartment, Upload, $http, GHelper, $timeout) {


    $scope.helper = GHelper;
    $scope.helper.isUserAuthorized($location, $rootScope);

    $rootScope.successMessage = "";
    $rootScope.showSuccessMessage = false;

    $rootScope.showSuccessMessageFunc = function (message) {
        $rootScope.successMessage = message;
        $rootScope.showSuccessMessage = true;
        $timeout(function () {
            $rootScope.showSuccessMessage = false;
        }, 2000);
    };


    $scope.showPreloader = true;
    $scope.loadingOwnerApartments = true;

    Apartment.query().$promise.then(function (data) {
        $scope.showPreloader = false;
        $scope.originalApartments = data;
        $scope.apartments = $scope.originalApartments;
    });

    if (store.get('profile') != null) {
        Apartment.query({owner_id: store.get('profile')['user_id']}).$promise.then(function (data) {
            $scope.ownerApartments = data;
            $scope.loadingOwnerApartments = false;
            $rootScope.checkForNewMessages();
        });
    }
    if (store.get('info_profile') != null) {
        $rootScope.user_profile = store.get('info_profile');
    }
        
    $rootScope.newApt = {};
    $rootScope.errorFields = undefined;

    $rootScope.showLogin = false;
    $rootScope.showSignup = false;
    $rootScope.showPost = false;

    $rootScope.newMsg = {};
    $rootScope.hasNewMessages = false;
    $rootScope.showConversation = false;

    $scope.propertyName = 'id';
    $scope.reverse = true;

    $scope.view = 'list';

    $scope.privateRoom = false;
    $scope.privateBath = false;
    $scope.kitchenIn = false;
    $scope.noDeposit = false;
    $scope.noCredit = false;

    /* Methods */

    $rootScope.login = function () {
        var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (regex.test($rootScope.username) && $rootScope.hasValidData($rootScope.password, 1)) {

            $http({
                url: 'api/login',
                method: "POST",
                data: {loginname: $rootScope.username, password: $rootScope.password},
                transformRequest: function (obj) {
                    var str = [];
                    for (var p in obj)
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    return str.join("&");
                },
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            }).then(function successCallback(response) {
                // this callback will be called asynchronously
                if (response.data.first_name) {
                    $rootScope.setInfoProfile($rootScope.username, response.data.uid,
                        response.data.first_name + " " + response.data.last_name,
                        response.data.first_name,
                        response.data.last_name,
                        response.data.user_roles_id,
                        response.data.address,
                        response.data.city,
                        response.data.email);
                    $rootScope.setProfile($rootScope.username, response.data.uid,
                        response.data.first_name + " " + response.data.last_name, response.data.user_roles_id);
                    $rootScope.showSuccessMessageFunc("Logged in !");
                    $rootScope.loginMessage = '';
                    $rootScope.showLogin = false;
                    $rootScope.checkForNewMessages();
                }
                else {
                    $rootScope.loginMessage = 'email or password incorrect';
                }
            }, function errorCallback(response) {
                // called asynchronously if an error occurs
                $rootScope.loginMessage = 'Error: ' + response;
            });

        } else {
            $rootScope.loginMessage = 'email or password incorrect';
        }
    };

    $rootScope.updateUserDetails = function () {
        $http({
            url: 'api/Users',
            method: "PUT",
            dataType: "json",
            //:email, :first_name, :last_name, :address, :city
            data: {
                email: $rootScope.user_profile.email,
                first_name: $rootScope.user_profile.user_first_name,
                last_name: $rootScope.user_profile.user_last_name,
                address: $rootScope.user_profile.address,
                city: $rootScope.user_profile.city
            }
        }).then(function successCallback(response) {
                // this callback will be called asynchronously
                    $rootScope.setInfoProfile($rootScope.username, response.data.data.uid,
                    response.data.data.first_name + " " + response.data.data.last_name,
                    response.data.data.first_name,
                    response.data.data.last_name,
                    response.data.data.user_roles_id,
                    response.data.data.address,
                    response.data.data.city,
                    response.data.data.email);
                $rootScope.updateMessage = 'Saved Changes';
            }
            ,
            function errorCallback(response) {
                // called asynchronously if an error occurs
                $rootScope.updateMessage = 'Error saving changes! Please try later.';
            }
        );
    };

    $rootScope.logout = function () {

        $http({
            url: 'api/logout',
            method: "POST"
        }).then(function successCallback(response) {
            // this callback will be called asynchronously
            if (response) {
                if (response.data === 'SUCCESS_LOGOUT') {
                    $rootScope.showSuccessMessageFunc("Logged out!");
                }
            } else {
                alert("Unable to logout");
            }
        }, function errorCallback(response) {
            // called asynchronously if an error occurs
            $rootScope.loginMessage = 'Error: ' + response;
        });


        store.remove('profile');
        $rootScope.first_name = "";
        $rootScope.last_name = "";
        $rootScope.username = "";
        $rootScope.password = "";
        $rootScope.address = "";
        $rootScope.hasNewMessages = false;
        $scope.go('/');
    };

    $rootScope.setProfile = function (u1, u2, u3, u4) {
        store.set('profile', {
            username: u1,
            user_id: u2,
            user_fullname: u3,
            user_role: u4
        });
    }

    $rootScope.setInfoProfile = function (u1, u2, u3, u4, u5, u6, u7, u8, u9) {
        store.set('info_profile', {
            username: u1,
            user_id: u2,
            user_fullname: u3,
            user_first_name: u4,
            user_last_name: u5,
            user_role: u6,
            address: u7,
            city: u8,
            email: u9
        });
        if (store.get('info_profile') != null) {
                $rootScope.user_profile = store.get('info_profile');
            $rootScope.user_profile = store.get('profile');
        }
    }

    $rootScope.signup = function () {
        var errors = "";
        var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        $rootScope.errorFields = undefined;
        if (regex.test($rootScope.username)) {
            // Name validations, e.g. Xi Li (China)
            if (!$rootScope.hasValidData($rootScope.first_name, 2)) {
                errors += "first_name, ";
            }
            if (!$rootScope.hasValidData($rootScope.last_name, 2)) {
                errors += "last_name, ";
            }
            // Simple password, not strict
            if (!$rootScope.hasValidData($rootScope.password, 1)) {
                errors += "password, ";
            }
            // Address and city
            if (!$rootScope.hasValidData($rootScope.address, 5)) {
                errors += "address, ";
            }
            if (!$rootScope.hasValidData($rootScope.city, 2)) {
                errors += "city";
            }

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
                    //store.set('profile', {username: $rootScope.username, user_id: response.data.data.user_id});
                    $rootScope.setInfoProfile($rootScope.username, response.data.data.uid,
                        response.data.data.first_name + " " + response.data.data.last_name,
                        response.data.data.first_name,
                        response.data.data.last_name,
                        response.data.data.user_roles_id, 
                        response.data.data.address, 
                        response.data.data.city,
                        response.data.data.email);
                    $rootScope.setProfile($rootScope.username, response.data.data.user_id,
                        response.data.data.first_name + " " + response.data.data.last_name, response.data.data.user_roles_id);
                    $rootScope.loginMessage = '';
                    $rootScope.showSuccessMessageFunc("Registered & Logged-in!");
                    $rootScope.showSignup = false;
                }, function errorCallback(response) {
                    $rootScope.loginMessage = response.data.reason;
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

    $rootScope.isAuthenticated = function () {
        return store.get('profile') != null;
    };

    $rootScope.getProfilePage = function () {
        return store.get('profile') != null ? (store.get('profile')['user_role'] == 1 ? '#/admin' : '#/profile') : '';
    };

    $rootScope.getFullName = function () {
        return store.get('profile') != null ? store.get('profile')['user_fullname'] : '';
    };

    $rootScope.getEmail = function () {
        return store.get('profile') != null ? store.get('profile')['username'] : '';
    };

    $rootScope.getUserID = function () {
        return store.get('profile') != null ? store.get('profile')['user_id'] : '';
    }

    $rootScope.checkForNewMessages = function () {
        if (store.get('profile') != null) {
            $http.post('/api/message/getNewMessagesCount', {
                email: $rootScope.getEmail(),
            }).success(function (data) {
                $rootScope.hasNewMessages = data.data.new_messages_count > 0;
            }).error(function (data) {
                console.log("Error: " + error.message);
            });
        }
    };

    $rootScope.postApartment = function () {
        if ($rootScope.isAuthenticated()) {
            $rootScope.showPost = true;
        } else {
            $rootScope.loginMessage = 'Please sign in to post an apartment!'
            $rootScope.showLogin = true;
        }
    };

    $rootScope.applyNow = function () {
        if ($rootScope.isAuthenticated()) {
            $rootScope.showApplyNow = true;
            $rootScope.newMsg = {
                apartment_id: $scope.apartment.id,
                from_user_id: $rootScope.getUserID(),
                to_user_id: $scope.apartment.owner_id,
                message: ''
            };
        } else {
            $rootScope.loginMessage = 'Please sign in to apply!'
            $rootScope.showLogin = true;
        }
    };

    $rootScope.sendThisMessage = function () {
        $http.post('/api/message/addNewMessage', $rootScope.newMsg).success(function (data) {
            $rootScope.showApplyNow = false;
        }).error(function (error) {
            console.log("Error: " + error.message);
        });
    }

    $rootScope.savePost = function () {
        $rootScope.newApt['owner_id'] = store.get('profile')['user_id'];
        Apartment.save($rootScope.newApt, function (data) {
            $rootScope.showPost = false;
            $rootScope.newApt = {};
            $scope.apartments.push(data);
            $scope.ownerApartments.push(data);
        }, function (data) {
            $rootScope.errorFields = data.data.error;
        });
    };

    $rootScope.deleteApartment = function (apartmentObj) {
        if (confirm("Are you sure to remove this apartment offer?")) {
            Apartment.delete({id: apartmentObj.id}, function () {
                $scope.ownerApartments.splice($scope.ownerApartments.indexOf(apartmentObj), 1);
            });
        }
    };

    $scope.uploadPic = function (file) {
        file.upload = Upload.upload({
            url: '/api/upload',
            data: {file: file}
        });
        file.upload.then(function (response) {
                file.result = response.data;
                if ($rootScope.newApt.pictures == undefined) {
                    $rootScope.newApt.pictures = response.data.files;
                } else {
                    $rootScope.newApt.pictures.push(response.data.files);
                }
            }, function (response) {
                if (response.status > 0) {
                    $scope.errorMsg = response.status + ': ' + response.data;
                }
            }, function (evt) {
                file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            }
        );
    };

    $scope.update = function () {
        if ($scope.minPrice == '') $scope.minPrice = undefined;
        if ($scope.maxPrice == '') $scope.maxPrice = undefined;
        if ($scope.minPrice == undefined && $scope.maxPrice == undefined) {
            $scope.apartments = $scope.originalApartments;
        } else {
            $scope.apartments = [];
            if ($scope.minPrice == undefined && $scope.maxPrice != undefined) {
                var min = 0;
                var max = parseFloat($scope.maxPrice);
            } else if ($scope.minPrice != undefined && $scope.maxPrice == undefined) {
                var min = parseFloat($scope.minPrice);
                var max = 100000;
            } else {
                var min = parseFloat($scope.minPrice);
                var max = parseFloat($scope.maxPrice);
            }
            angular.forEach($scope.originalApartments, function (apartment, key) {
                if (apartment.monthly_rent >= min && apartment.monthly_rent <= max) {
                    $scope.apartments.push(apartment);
                }
            });
        }
    };

    $scope.sortBy = function (propertyName) {
        $scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
        $scope.propertyName = propertyName;
    };

    $scope.go = function (path) {
        $location.path(path);
        $rootScope.checkForNewMessages();
    };

}]);
