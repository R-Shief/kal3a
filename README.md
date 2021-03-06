Rshief Kal3a -- قلعة
====================

Kal3a is a platform for collecting and storing social media artifacts.

Currently, Kal3a suports Twitter and PubSub notifications. All input is transformed into [Atom entries](https://tools.ietf.org/html/rfc4287) for indexing. Original data is also retained.

## Software Requirements

* [PHP 7.0](http://php.net) - a language and runtime.
* [Composer](https://getcomposer.org) - a PHP dependency manager.
* [MySQL](http://dev.mysql.com/downloads/) - a relational database.
* [CouchDB 1.6](http://couchdb.apache.org) - a document (NoSQL) database.
* [Elasticsearch 2.0](https://www.elastic.co/products/elasticsearch) - a search service.
* [Logstash 2.1](https://www.elastic.co/products/logstash) - a pipeline for moving data between services.
* [RabbitMQ 3.6](https://www.rabbitmq.com) - a message queue.

Kal3a requires multiple long-running processes, so a process manager is advised. For development, you should consider
[Invoker](http://invoker.codemancers.com). An example configuration for invoker is included. For production, you should
consider [Supervisor](http://supervisord.org).

Although there are many dependencies, you can rely on distribution packages and their default configuration during
development. Some of the listed dependencies have dependencies of their own which are not listed here.

For Elasticsearch, these **optional** plugins will make development easier by providing a web UI for monitoring the
server and running queries:

```bash
plugin -install royrusso/elasticsearch-HQ
plugin -install mobz/elasticsearch-head
plugin -install polyfractal/elasticsearch-inquisitor
```

## Capacity Planning

We have found that Kal3a can easily handle 4 million entries per day, which is the theoretical maximum that Twitter
will serve to a normal API user. We found that 2 million entries per day amounted to approximately 500 GB of data
storage in both CouchDB and Elasticsearch. While Elasticsearch can be clustered, CouchDB's default distribution cannot.
CouchDB 2 will support clustering but is [still being tested](https://docs.google.com/document/d/1BtndYr-0KDQTqBSLVdJoR_8C5ObYjT1RBo_Qyh5ykdQ/edit).

While Kal3a could collect and store data indefinitely, you probably do not have infinite resources to support such a
strategy. Kal3a includes a command to purge data when it is older than a specific date.

You must always have twice the capacity for CouchDB so that it can [compact the database](http://docs.couchdb.org/en/1.6.1/maintenance/compaction.html)
after purging.

Assuming your Elasticsearch index can be unavailable occasionally, you can always delete the Elasticsearch index to
make free space if it is colocated with CouchDB. For Kal3a, Elasticsearch never contains unique data.

## Installation

* Install all the listed requirements (above) according to the documentation for those applications. The rest of this
  documentation assumes you are running the services on `localhost` listening on the application's default port.
* `git clone https://github.com/R-Shief/kal3a.git` This downloads a copy of the project to your environment.
* `cd kal3a`
* Install Docker.
* Run `docker-compose run -e COMPOSER_AUTH="${COMPOSER_AUTH}" --rm composer install --ignore-platform-reqs --no-scripts`
  to install PHP dependencies. During this step, you may be asked to review some configuration details. You can
  safely accept the default value for every choice. These settings are saved to `app/config/parameters.yml`.

### Starting up

First start Consul. In production, Consul performs health check, supports service discovery and distributes key-value
data for use as configuration.

* `docker-compose up consul`

### Twitter Keys

Use your own Twitter application keys and credentials and put them into Consul.

* `docker-compose exec consul consul kv put twitter/consumer_key 20202020202020202020`
* `docker-compose exec consul consul kv put twitter/consumer_secret 393939393939393939393939393939393939393`
* `docker-compose exec consul consul kv put twitter/1/access_token 55555-4343434343434343434343434343434343434343434`
* `docker-compose exec consul consul kv put twitter/1/access_token_secret 646464646464646464646464646464646464646464646`

Once Consul has Twitter credentials, it is safe to launch other services.

### Web

Launch the web service and all of its dependencies:

* `docker-compose up web`

CouchDB, Elasticsearch, RabbitMQ and MySQL should now be running.

Establish the CouchDB instance as a single node cluster:

* `curl -X PUT http://127.0.0.1:5984/_users -u couchdb:couchdb`
* `curl -X PUT http://127.0.0.1:5984/_replicator -u couchdb:couchdb`
* `curl -X PUT http://127.0.0.1:5984/_global_changes -u couchdb:couchdb`

Create the kal3a database in CouchDB:

* `curl -X PUT http://127.0.0.1:5984/kal3a -u couchdb:couchdb`
* `docker-compose run --rm console doctrine:couchdb:update-design-doc`

Create the MySQL database and install the schema:

* `docker-compose run --rm console doctrine:database:create`
* `docker-compose run --rm console doctrine:schema:create`

Create the Elasticsearch index:

* `docker-compose run --rm console ongr:es:index:create`

Setup RabbitMQ:

* `docker-compose run --rm console rabbitmq:setup-fabric`

Create the administrator user:

* `docker-compose run --rm console fos:user:create --super-admin`

Finally, visit `http://localhost:8000` to access the web interface of your local development instance of kal3a.

### Beware!

All data in the containers are volatile. The kal3a source code is mounted into the containers,
but the databases, queue storage and Elasticsearch index are all destroyed when containers are
shut down.

### Orientation

Kal3a is built with the [Symfony](http://symfony.com) framework, which is a well-tested
web framework built from reusable components. It is inspired by Spring and Django, so its
conventions may look familiar to you if you have worked with those. Symfony uses
dependency injection to configure services in a container. Configuration can be made with
XML, YAML, PHP and annotations. This application uses YAML, XML and annotations.

Kal3a offers a web service endpoint and multiple [command processes](http://symfony.com/doc/current/components/process.html) that need to be run
with cron or long-running background tasks.

Symfony-specific code is modularized as [bundles](http://symfony.com/doc/current/cookbook/bundles/index.html) which are registered in the kernel at `app/AppKernel.php`. Kal3a uses these bundles:

These bundles are included in Symfony's standard distribution:

* Symfony Framework Bundle - core functionality that binds Symfony components together into a basic application.
* Monolog Bundle - logging.
* Security Bundle - authentication and authorization.
* Swiftmailer Bundle - transactional emails (mostly unused in kal3a).
* Twig Bundle - PHP templates with Twig
* Liip Monitor Bundle - Monitors the availability of backend services.
* Sensio Framework Extra Bundle - expands configuration by annotation for routes.
* Doctrine Bundle - for object relational mapping of entities.

These bundles are additional dependencies:

* FOS REST Bundle - supports API development.
* FOS User Bundle - simplifies user management.
* FOS JS Routing Bundle - exposes Symfony routes to JavaScript applications.
* Nelmio CORS Bundle - supports CORS for decoupled front-end applications and APIs.
* Doctrine CouchDB Bundle - for CouchDB client.
* Caxy Elasticsearch Bundle - for establishing Elasticsearch index, client and mappings.
* Easy Admin Bundle - generated admin UI.
* Nelmio API Doc Bundle - generated API documentation and sandbox.
* Old Sound RabbitMQ Bundle - for configuration of message queues and client access.
* Bangpound Guzzle Proxy Bundle - filters and proxies requests from front end applications to backend services.

These bundles are contained within the `bundles` directory and are custom for Kal3a. With
few exceptions, they don't need to be independent of each other, and their names are a poor
indication of their functionality.

* Bangpound ATOM data bundle - mappings and serialization of Atom data to PHP objects.
* Bangpound Castle bundle - assorted controllers and classes for serialization.
* Bangpound Castle Search bundle - includes a statistics controller.
* Bangpound Twitter Streaming bundle - integration with Twitter streaming API.
* Rshief Kal3a Bundle - assorted controllers and unfinished work.
* App Bundle - user entities. Best practices in Symfony say that custom code for an application should be kept in a bundle with this name.

Symfony builds a cache for each runtime environment at `var/cache` and stores logs at
`var/logs`. The *contents* of these directories can safely be deleted during development
without secondary consequences.

### Maintenance

All of these cron tasks need to be run with `SYMFONY_ENV=prod` in the environment. Otherwise
your logs and memory usage will be huge.

Given the capacity constraints, you probably need to regularly purge the database of old
content. Set up a cron task to purge content on a daily basis:

```
bin/console castle:prune
```

To maintain the CouchDB views, run hourly with each task staggered by 5 minutes:

```bash
bin/console castle:view:update default enclosure tags
bin/console castle:view:update default lang basic
bin/console castle:view:update default maint date
bin/console castle:view:update default nofollow tags
bin/console castle:view:update default published timeseries
bin/console castle:view:update default tag timeseries
bin/console castle:view:update default tag_trends PT1M
```

### Production

Configure your web server to serve from the `web` directory of the project. Kal3a uses the Symfony 3 framework so refer
to [Configuring a Web Server](http://symfony.com/doc/current/cookbook/configuration/web_server_configuration.html) in
the official Symfony Cookbook which has advice for Apache and nginx. Using PHP-FPM is recommended.

### Troubleshooting

Whenever you `git pull` updates or update dependencies, Kal3a may give a fatal error because it has a stale cache. Run
`bin/console cache:clear --env=prod` to clear the cache.

## Twitter

### Configuration

* Acquire API credentials from <https://apps.twitter.com>.
* Add these credentials to `app/config/parameters.yml`

Twitter Streaming requires that you configure your tracking, Visit `http://localhost:8000/admin` and create some "track" entities.
Follow entities will configure the streaming API to follow users by their numeric ID. Location
entities will configure the streaming API to acquire tweets within a bounding box.

For durable long-running processes, use `--env=prod` or set `SYMFONY_ENV=prod` for
`bin/console` processes:

* `bin/console phirehose:consume:basic` to connect to the Twitter streaming endpoint and capture tweets. This process converts tweets into Atom entities and queues them in RabbitMQ.
* `bin/console rabbitmq:consumer -m 1000 twitter` to move data from RabbitMQ into CouchDB in batches of 1000.
* `logstash -f logstash/couchdb-pipeline.conf` to move new records from CouchDB to Elasticsearch.

If you are using `invoker` in your local development environment, the above tasks can be started with:

```bash
invoker start
invoker add phirehose
invoker add consumer
```

## Exporting

You can export slices of your acquired data set with this command. Dates should be represented
in ISO 8601 format (e.g. 2015-12-10 for 12 December 2015).

```bash
bin/console castle:export [tag] [start-date] [end-date] -o export.json
```

The JSON contains nested entities, so we advise [OpenRefine](http://openrefine.org) for
transforming the JSON if necessary into another format like CSV.
