function ResultPager(request, hits) {
    var total = Math.ceil(hits / request.size);
    total = total === 0 ? 1 : total;
    var current = Math.ceil((request.from / request.size) + 1);
 
    return {
        total: function() {
            return total;
        },
        current: function() {
            return current;
        },
        next: function() {
            var next = current;
            if (current < total) {
                next = current + 1;
            }
            return next;
        },
        previous: function() {
            var previous = current;
            if (current > 1) {
                previous = current - 1;
            }
            return previous;
        },
        pages: function(min, max) {
            var pages = [],
            end = current + min < total ? current + min : total + 1,
            start = end - max > 1 ? end - max : 1,
            i;
 
            for (i = start; i < end; i++) {
                pages.push(i);
            }
            return pages;
        },
        get: function(page) {
            var start = (page * request.size) - request.size;
            return start;
        }
    };
}
