/**
 * Created by Manasés Galindo on 10/12/16.
 * Controller used by the landlord/renter profile.
 * Uses the message api
 */

app.controller('profileController', ['$scope', '$rootScope', 'Apartment', 'User', '$http', function($scope, $rootScope, Apartment, User, $http) {

    // Controller variables
    $rootScope.showConversation = false;

    $scope.view = 'messages';
    $scope.errorMessage = 'error aqui';
    $scope.convHeader = { };

    // Get all messages for logged user
    $http.post('/api/message/getMessages', {
        email : $rootScope.getEmail(),
        page_number : 1
    }).success(function (data) {
        $scope.messages = data.data;
    }).error(function (error) {
        console.log("Error: " + error.message);
    });

    // Get a conversation
    $scope.getConversation = function (message) {
        $scope.convHeader = {
            from_user : message.from_user,
            received_on : message.received_on,
            apartment_title : message.apartment_title
        };

        $http.post('/api/message/getConversation', {
            email : $rootScope.getEmail(),
            apartment_id : message.apt_id,
            fromuser_email : message.from_user_email,
            page_number : 1
        }).success(function (data) {
            $scope.conversations = data.data;
            $rootScope.showConversation = true;
        }).error(function (error) {
            console.log("Error: " + error.message);
        });
    }
}]);

