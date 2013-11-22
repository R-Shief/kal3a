castleSearch
    .filter('twitterProfile', function ($filter) {
        return function (input) {
            return input.default_profile_image ? 'http://robohash.org/'+input.screen_name+'.png' : input.profile_image_url;
        };
    })
    .filter('atomThumbnail', function($filter) {
        return function (input) {
            var thumbnailLink = _.findWhere(input.links, { rel: 'thumbnail' })
                || _.findWhere(input.links, { rel: 'image' })
                || _.findWhere(input.links, { type: 'image' })
                || _.findWhere(input.links, { rel: 'author thumbnail' })
                || { href: 'http://placehold.it/96x96' };

            return thumbnailLink.href;
        }
    })

    .filter('directionality', function ($filter) {
        return function (input) {
            var rtlChars = '\u0591-\u07FF\uFB1D-\uFDFF\uFE70-\uFEFC',
                rtlCharReg = new RegExp('[' + rtlChars + ']'),
                rtlReg = new RegExp('^[' + rtlChars + ']');

            return rtlCharReg.test(input) ? 'rtl' : 'ltr';
        };
    })

    .filter('alternateHref', function ($filter) {
        return function(input) {
            var alternateLink = _.findWhere(input, { rel: 'alternate' }) || _.findWhere(input, { rel: '' }) || _.findWhere(input, { rel: 'canonical' }) || { href: '' };

            return alternateLink.href;
        };
    });
