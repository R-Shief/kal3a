castleSearch = angular.module('castleSearch', [
        'ngSanitize',
        'ajoslin.promise-tracker',
        'elasticjs.service',
        'dangle'
    ])
    .config(function($locationProvider) {
        $locationProvider.html5Mode(true);
    })
    .constant('ejsConfig', {server: castle.serverUrl, tracker: 'searching'})
;
