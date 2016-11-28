app.factory('OwnedApartments', ['$resource', function($resource) {
    return userResource = $resource('/api/apartment/owner', {
        owner_id: '@owner_id'
    });
}]);