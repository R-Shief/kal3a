castleSearch = angular.module('castleSearch', [
        'ngSanitize',
        'ajoslin.promise-tracker',
        'elasticsearch',
        'dangle'
    ])
    .service('es', function (esFactory) {
        return esFactory({
            host: castle.serverUrl
        });
    })
    .config(function($locationProvider) {
        $locationProvider.html5Mode(true);
    })
;
