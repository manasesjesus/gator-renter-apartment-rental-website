/**
 * Created by Manasés Galindo on 10/12/16.
 * Controller used by the landlord/renter profile.
 * Uses the message api
 */

app.controller('profileController', ['$scope', '$rootScope', 'Apartment', 'User', '$http', function($scope, $rootScope, Apartment, User, $http) {

    // Controller variables
    $rootScope.updateMessage = '';
    $rootScope.showConversation = false;

    $scope.view = 'messages';
    $scope.errorMessage = 'error aqui';
    $scope.convHeader = { };

    // Get all messages for logged user
    $http.post('/api/Message/getMessages', {
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
            apartment_title : message.apartment_title,
        };

        $http.post('/api/Message/getConversation', {
            email : $rootScope.getEmail(),
            apartment_id : message.apt_id,
            fromuser_email : message.from_user_email,
            page_number : 1
        }).success(function (data) {
            $scope.conversations = data.data;
            $rootScope.showConversation = true;
            $rootScope.newMsg = {
                apartment_id: message.apt_id,
                from_user_id: $rootScope.getUserID(),
                to_user_id: data.data[0].to_user_id == $rootScope.getUserID() ? data.data[0].from_user_id : data.data[0].to_user_id,
                message: ''
            };
        }).error(function (error) {
            console.log("Error: " + error.message);
        });
    }

    // Reply on a conversation
    $scope.reply = function () {
        $http.post('/api/Message/addNewMessage', $rootScope.newMsg).success(function (data) {
            $rootScope.showConversation = false;
        }).error(function (error) {
            console.log("Error: " + error.message);
        });
    }
}]);

