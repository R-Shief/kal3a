castleSearch
    .directive('searchResult', ['$compile', '$http', '$templateCache', function($compile, $http, $templateCache) {

        var getTemplate = function(type) {
            var templateLoader,
            baseUrl = castle.basepath + '/templates/components/result/',
            templateMap = {
                atom: 'atom.html',
                error_message: 'error_message.html'
            };

            var templateUrl = baseUrl + templateMap[type];
            templateLoader = $http.get(templateUrl, { cache: $templateCache });

            return templateLoader;

        }

        var linker = function(scope, element, attrs) {
            var loader = getTemplate(scope.doc._type);
            var promise = loader.success(function(html) {
                element.html(html);
            }).then(function (response) {
                element.replaceWith($compile(element.html())(scope));
            });
        }

        return {
            restrict: 'E',
            scope: {
                doc: '='
            },
            link: linker
        };
    }])
    .directive('atomTextConstruct', function() {
      return {
        restrict: 'E',
        scope: {
            atomElement: '='
        },
        link: function(scope, element, attrs) {

            var filterTags = function (html) {
                var tmp = document.createElement("DIV");
                tmp.innerHTML = html;
                return tmp.textContent||tmp.innerText;
            }


            var html, type;

            if (scope.hasOwnProperty('atomElement') && scope.atomElement != null) {

                type = scope.atomElement.hasOwnProperty('type') ? scope.atomElement.type : 'text';

                if (type == 'html' || type == 'xhtml') {
                    html = scope.atomElement.text;
                }
                else {
                    html = '<p>' + scope.atomElement.text + '</p>';
                }

                html = '<p>' + _.str.prune(filterTags(html), 200, '...') + '</p>';

                element.replaceWith(html);
            }
        }
      };
    })
    .directive('errSrc', function() {
        return {
            link: function(scope, element, attrs) {
                element.bind('error', function() {
                    element.attr('src', attrs.errSrc);
                });
            }
        }
    })
    .directive('twitterText', function () {
        return {
            restrict: 'E',
            scope: {
                tweet: '='
            },
            link: function(scope, element, attrs) {
                element.replaceWith(twttr.txt.autoLink(tweet.text.text, { urlEntities: tweet.entities.urls }));
            }
        };
    });

