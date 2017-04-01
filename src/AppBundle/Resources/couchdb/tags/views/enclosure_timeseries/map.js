function (doc)
{
    var utc = doc.published.split(/\D/);
    utc[1] = utc[1] - 1;
    var date = new Date(Date.UTC.apply(null, utc));
    if (date && doc.links && doc.categories) {
        doc.categories.forEach(function (category) {
            doc.links.forEach(function (link) {
                if (link.rel === 'enclosure') {
                    emit([category.term.toLowerCase(), date.getUTCFullYear(), date.getUTCMonth() + 1, date.getUTCDate(), link.href ], 1);
                }
            });
        });
    }
}
