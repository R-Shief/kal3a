/*global castle, angular */
var castleSearch;
castleSearch = angular.module('castleSearch', ['ngSanitize', 'elasticsearch', 'ui.bootstrap'])
    .service('es', function (esFactory) {
        "use strict";

        var parser = document.createElement('a');
        parser.href = Routing.generate('bangpound_elasticsearch_proxy', {}, true);

        return esFactory({
            host: parser.hostname + ':' + parser.port + parser.pathname
        });
    })
    .config(function ($locationProvider) {
        "use strict";
        $locationProvider.html5Mode(true);
    });
