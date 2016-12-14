/**
 * Created by Manasés Galindo on 10/12/16.
 * Service used by the adminController to get all users
 */
app.factory('User', ['$resource', function($resource) {
    return userResource = $resource('/api/Users', {
        id: 'admin'
    });
}]);