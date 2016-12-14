/**
 * Created by Manasés Galindo on 09/12/16.
 * Controller used by the admin profile
 */
app.controller('adminController', ['$scope', '$rootScope', 'store', 'Apartment', 'User', '$http', function($scope, $rootScope, store, Apartment, User, $http) {

    $rootScope.showLogin = false;
    $rootScope.showSignup = false;
    $rootScope.showPost = false;

    $scope.propertyName = 'id';
    $scope.reverse = true;

    $scope.view = 'users';

    Apartment.query().$promise.then(function(data) {
        $scope.loadingOwnerApartments = false;
        $scope.apartments = data;
    });

    $scope.loadAllUsers = function () {
        $scope.loadingUsers = true;
        User.query().$promise.then(function(data) {
            $scope.loadingUsers = false;
            $scope.allUsers = data;
        });
    }
    $scope.loadAllUsers();

    $scope.toggleUser = function (userId, status) {
        status = status == 0 ? 1 : 0;
        $http.delete('api/Users?uid=' + userId + "&status=" + status).then(function successCallback(response) {
            $scope.loadAllUsers();
        }, function errorCallback(response) {
            console.log("Something unexpected happened...");
        });
    }

    $scope.deleteThisApartment = function (apartmentObj) {
        if (confirm("Are you sure to remove this apartment offer?")) {
            Apartment.delete({id: apartmentObj.id}, function () {
                $scope.apartments.splice($scope.apartments.indexOf(apartmentObj), 1);
            });
        }
    };
}]);

