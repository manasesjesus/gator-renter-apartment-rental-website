app.factory('Apartment', ['$resource', function($resource) {
	return userResource = $resource('/~f16g08/api/apartment', {
		apartment_id: '@apartment_id'
	});
}]);