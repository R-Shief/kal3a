Kal3a
=====

Create river between CouchDB and Elasticsearch
----------------------------------------------

curl -XPUT 'localhost:9200/_river/symfony/_meta' -d '{
    "type" : "couchdb",
    "couchdb" : {
        "host" : "localhost",
        "port" : 5984,
        "db" : "symfony",
        "filter" : null
    },
    "index" : {
        "index" : "symfony",
        "type" : "symfony",
        "bulk_size" : "100",
        "bulk_timeout" : "10ms"
    }
}'
