/*global castleSearch, _ */
/*jshint bitwise:true, curly:true, eqeqeq:true, forin:true, noarg:true, noempty:true, nonew:true, undef:true, strict:true, latedef:true, unused:true, indent:4, browser:true */
castleSearch
    .directive('atomTextConstruct', function () {
        'use strict';
        return {
            restrict: 'E',
            scope: {
                atomElement: '='
            },
            link: function (scope, element, attrs) {
                var filterTags, html, type;
                filterTags = function (html) {
                    var tmp = document.createElement('DIV');
                    tmp.innerHTML = html;
                    return tmp.textContent || tmp.innerText;
                };

                if (scope.hasOwnProperty('atomElement') && scope.atomElement !== null) {

                    type = scope.atomElement.hasOwnProperty('type') ? scope.atomElement.type : 'text';

                    if (type === 'html' || type === 'xhtml') {
                        html = scope.atomElement.text;
                    } else {
                        html = '<p>' + scope.atomElement.text + '</p>';
                    }

                    html = '<p>' + _.str.prune(filterTags(html), 200, '...') + '</p>';

                    element.replaceWith(html);
                }
            }
        };
    })
    .directive('errSrc', function () {
        'use strict';
        return {
            link: function (scope, element, attrs) {
                element.bind('error', function () {
                    element.attr('src', attrs.errSrc);
                });
            }
        };
    });

