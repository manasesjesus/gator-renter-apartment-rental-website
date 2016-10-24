app.factory('Apartment', ['$resource', function($resource) {
	return userResource = $resource('/gator-renter/api/apartment', {
		apartment_id: '@apartment_id'
	});
}]);