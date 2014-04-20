castleSearch
    .controller('SearchCtrl', function($location, $scope, es) {
        var oQuery = ejs.QueryStringQuery();

        $scope.queryTerm = castle.query.queryTerm;

        $scope.query = ejs.Request();

        $scope.activeFilters = {};

        if (castle.query.tag) {
            $scope.activeFilters['Tags (# and meta):' + castle.query.tag] = ejs.TermFilter('categories.term', castle.query.tag);
        }

        if (castle.query.published_lower) {
            $scope.activeFilters['Date posted:' + castle.query.published_lower] = ejs.NumericRangeFilter('published')
                .from(parseInt(castle.query.published_lower, 10))
                .to(parseInt(castle.query.published_upper, 10));
        }

        if (castle.query.collection) {
            $scope.activeFilters['Collection:' + castle.query.collection] = ejs.TermFilter('type', castle.query.collection);
        }

        $scope.query.from(0);
        $scope.query.size(25);

        $scope.query.facet(ejs.TermsFacet('Language')
            .field('lang')
            .size(10));

        $scope.query.facet(ejs.TermsFacet('Source')
            .field('source.title.text')
            .size(10));

        $scope.query.facet(ejs.TermsFacet('Author')
            .field('authors.name')
            .size(10));

        $scope.query.facet(ejs.TermsFacet('Tags (# and meta)')
            .field('categories.term')
            .size(10));

        $scope.query.facet(ejs.TermsFacet('Collection')
            .field('type')
            .size(10));

        $scope.query.facet(ejs.DateHistogramFacet('Date posted')
            .field('published')
            .interval('day'));

        $scope.pager = {
            next: function() {
                if ($scope.query.from() + $scope.query.size() < $scope.results.hits.total) {
                    $scope.query.from($scope.query.from() + $scope.query.size());
                    $scope.search();
                }
            },

            prev: function() {
                if ($scope.query.from() - $scope.query.size() >= 0) {
                    $scope.query.from($scope.query.from() - $scope.query.size());
                    $scope.search();
                }
            }
        }

        $scope.applyFilters = function(query) {

            var filter = null;
            var filters = Object.keys($scope.activeFilters).map(function(k) { return $scope.activeFilters[k]; });

            if (filters.length > 1) {
                filter = ejs.AndFilter(filters);
            } else if (filters.length === 1) {
                filter = filters[0];
            }

            return filter ? ejs.FilteredQuery(query, filter) : query;
        };

        $scope.filterByDate = function (key, term) {
            key = 'Date posted';
            if ($scope.isActive(key, term)) {
                delete $scope.activeFilters[key + ':' + term];
            } else {
                var filters = [];
                var facets = $scope.query.facet()[key];
                angular.forEach(facets, function (facet, type) {
                    var fields = facet.hasOwnProperty('fields') ? facet.fields : [ facet.field ];
                    angular.forEach(fields, function (value) {
                        filters.push(ejs.NumericRangeFilter(value).from(term));
                    });
                });

                if (filters.length > 1) {
                    filter = ejs.OrFilter(filters);
                } else if (filters.length === 1) {
                    filter = filters[0];
                }
                $scope.activeFilters[key + ':' + term] = filter;
            }
            $scope.search();
        };

        $scope.sort = '_score';

        $scope.toggleSort = function () {
            if (this.sort === '_score') {
                this.sort = 'desc';
            }
            else if (this.sort === 'desc') {
                this.sort = 'asc';
            }
            else if (this.sort === 'asc') {
                this.sort = '_score';
            }
            this.search();
        };

        $scope.search = function() {

            $scope.loading = true;

            var sort = ejs.Sort();

            if (this.sort === '_score') {
                sort.field(this.sort);
            }
            else {
                sort.field('published').order(this.sort);
            }

            $scope.query.sort([sort]);

            $scope.query
                .query($scope.applyFilters(oQuery.query($scope.queryTerm || '*')));

            es.search({
                    body: $scope.query
                }, function (error, results) {
                    $scope.results = results;
                    angular.forEach(results.hits.hits, function (value, key) {

                        var thumbnailLink = _.findWhere(value._source.links, { rel: 'thumbnail' })
                            || _.findWhere(value._source.links, { rel: 'image' })
                            || _.findWhere(value._source.links, { type: 'image' })
                            || _.findWhere(value._source.links, { rel: 'author thumbnail' })
                            || { href: 'http://placehold.it/96x96' };

                        var authorLink = _.findWhere(value._source.links, { rel: 'author' });

                        var canonicalLink = _.findWhere(value._source.links, { rel: 'canonical' });

                        var alternateLink = _.findWhere(value._source.links, { rel: 'alternate' }) || _.findWhere(value._source.links, { rel: '' });

                        var displayLinks = _.without(value._source.links, thumbnailLink, authorLink, canonicalLink, alternateLink);

                        angular.forEach(displayLinks, function (link) {
                            if (!link.hasOwnProperty('title')) {
                                link.title = link.href
                            }
                            if (link.hasOwnProperty('rel') && link.rel === 'canonical') {
                                link.title = link.rel;
                            }
                        });

                        $scope.results.hits.hits[key].castleView = {
                            thumbnailLink: thumbnailLink,
                            authorLink: authorLink,
                            canonicalLink: canonicalLink,
                            alternateLink: alternateLink,
                            displayLinks: displayLinks
                        };
                    });
                    $scope.loading = false;
                }
            );
        };

        $scope.search();

        $scope.isActive = function (key, term) {
            return $scope.activeFilters.hasOwnProperty(key + ':' + term);
        };

        $scope.reset = function () {
            this.activeFilters = {};
            this.query.from(0);
            this.query.size(25);
            this.sort = '_score';
            this.queryTerm = '';
            this.search();
        };
    })
    .controller('TermFacet', function ($scope, $window) {
        $scope.typeNames = $window.castle.typeNames;

        $scope.init = function (key, query) {
            $scope.key = key;
            $scope.query = query;
        }

        $scope.filter = function (key, term) {
            if ($scope.isActive(key, term)) {
                delete $scope.activeFilters[key + ':' + term];
            } else {
                var filters = [];
                var facets = $scope.query.facet()[key];
                angular.forEach(facets, function (facet, type) {
                    var fields = facet.hasOwnProperty('fields') ? facet.fields : [ facet.field ];
                    angular.forEach(fields, function (value) {
                        filters.push(ejs.TermFilter(value, term));
                    });
                });

                if (filters.length > 1) {
                    filter = ejs.OrFilter(filters);
                } else if (filters.length === 1) {
                    filter = filters[0];
                }
                $scope.activeFilters[key + ':' + term] = filter;
            }
            this.search();
        };
    });
