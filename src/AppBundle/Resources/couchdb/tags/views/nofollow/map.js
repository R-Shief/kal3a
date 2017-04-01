function (doc)
{
    var utc = doc.published.split(/\D/);
    utc[1] = utc[1] - 1;
    var date = new Date(Date.UTC.apply(null, utc));
    if (date && doc.links && doc.categories) {
        doc.categories.forEach(function (category) {
            doc.links.forEach(function (link) {
                if (link.rel === 'nofollow') {
                    emit([category.term.toLowerCase(), link.href ], 1);
                }
            });
        });
    }
}
