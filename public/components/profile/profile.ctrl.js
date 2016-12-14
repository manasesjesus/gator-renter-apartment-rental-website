/**
 * Created by Manasés Galindo on 10/12/16.
 * Controller used by the landlord/renter profile.
 * Uses the message api
 */

app.controller('profileController', ['$scope', '$rootScope', 'Apartment', 'User', '$http', function($scope, $rootScope, Apartment, User, $http) {

    $rootScope.showLogin = false;
    $rootScope.showSignup = false;

    $scope.propertyName = 'id';
    $scope.reverse = true;

    $scope.view = 'messages';

    // Get all messages for logged user
    $http.post('/api/message/getMessages', {
        email : $rootScope.getEmail(),
        page_number : 1
    }).success(function (data) {
        $scope.messages = data.data;
    }).error(function (data) {
        console.log("Error: " + error.message);
    });

    // Open a conversation
    $scope.getConversation = function (message) {
        console.log(message.from_user);
        console.log(message.apartment_title);
    }
}]);

