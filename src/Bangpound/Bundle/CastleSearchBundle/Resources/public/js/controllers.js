castleSearch
    .controller('SearchCtrl', function($location, $scope, ejsResource, ejsConfig, promiseTracker) {
        var ejs = ejsResource(ejsConfig);
        var oQuery = ejs.QueryStringQuery();

        $scope.queryTerm = $location.search()['queryTerm'];

        $scope.query = ejs.Request();

        $scope.activeFilters = {};

        $scope.ninjaFinder = promiseTracker('searching');

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

        $scope.query.facet(ejs.TermsFacet('Type')
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

        $scope.sort = {
            fieldName: 'published',
            order: 'desc'
        };

        $scope.toggleSort = function () {
            $scope.sort.order = ($scope.sort.order === 'desc') ? 'asc' : 'desc';
            this.search();
        };

        $scope.search = function() {

            var sort = ejs.Sort(this.sort.fieldName).order(this.sort.order);

            $scope.query.sort([sort]);

            $scope.query
                .query($scope.applyFilters(oQuery.query($scope.queryTerm || '*')))
                .doSearch()
                .then(function (results) {
                    $scope.results = {};
                    angular.forEach(results, function (value, key) {
                        $scope.results[key] = value;
                    });
                });
        };

        $scope.search();

        $scope.isActive = function (key, term) {
            return $scope.activeFilters.hasOwnProperty(key + ':' + term);
        };

        $scope.reset = function () {
            this.activeFilters = {};
            this.query.from(0);
            this.query.size(25);
            this.sort.fieldName = 'published';
            this.sort.order = 'desc';
            this.queryTerm = '';
            this.search();
        };
    })
    .controller('TermFacet', function ($scope) {
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
