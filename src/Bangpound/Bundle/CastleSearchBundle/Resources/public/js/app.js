/*global castle, angular */
var castleSearch;
castleSearch = angular.module('castleSearch', ['ngSanitize', 'elasticsearch'])
    .service('es', function (esFactory) {
        "use strict";
        return esFactory({
            host: castle.serverUrl
        });
    })
    .config(function ($locationProvider) {
        "use strict";
        $locationProvider.html5Mode(true);
    });
