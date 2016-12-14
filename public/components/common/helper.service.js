/**
 * Created by Intesar Haider on 12/14/2016.
 */
app.factory('GHelper', function ($window, store) {
    var root = {};

    root.getTitle = function($location){

        var pageTitle = $location.url().substring(1);

        return pageTitle;

    };

    root.isAuthenticated = function () {
        return store.get('profile') != null;
    };

    root.redirect = function (path, $location) {
        $location.path(path);
    }

    root.isUserAuthorized = function($location, $rootScope){

        console.log("isUserAuthenticated in helper service called!");

        //Re-directions
        if (root.getTitle($location)==='profile') {

            if(root.isAuthenticated()){
                console.log("you are good to go ! ")
            } else {
                console.log("Pleas sign in !!  ");
                $rootScope.loginMessage = 'Please sign in to visit this page!';
                $rootScope.showLogin = true;
                root.redirect('/', $location);
            }
        }

    };

    return root;
});