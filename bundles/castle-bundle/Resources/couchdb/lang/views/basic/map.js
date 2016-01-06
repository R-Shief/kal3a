function (doc)
{
    if (doc.lang) {
        emit(doc.lang, 1);
    }
}
