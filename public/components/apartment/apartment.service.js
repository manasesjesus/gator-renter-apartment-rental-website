app.factory('Apartment', ['$resource', function($resource) {
	return userResource = $resource('/api/apartment', {
		apartment_id: '@apartment_id'
	});
}]);