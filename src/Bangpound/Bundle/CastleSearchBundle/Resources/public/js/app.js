/*global castle, angular */
var castleSearch;
castleSearch = angular.module('castleSearch', ['ngSanitize', 'ngResource', 'elasticsearch', 'ui.bootstrap'])
    .service('es', function (esFactory) {
        "use strict";

        var parser = document.createElement('a');
        parser.href = Routing.generate('bangpound_elasticsearch_proxy', {}, true);

        return esFactory({
            host: parser.hostname + ':' + parser.port + parser.pathname
        });
    })
    .factory('Tag', ['$resource', function ($resource) {
        var url = NgRouting.generateResourceUrl('get_tagstatistic');
        return $resource(url, { _format: 'json'}, {
            'get': { method: 'GET', isArray: true }
        });
    }])
    .config(function ($locationProvider) {
        "use strict";
        $locationProvider.html5Mode(true);
    });
