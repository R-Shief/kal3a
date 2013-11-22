castleSearch
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

                if (type === 'html' || type === 'xhtml') {
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
    });

