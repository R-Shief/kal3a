Rshief Kal3a -- قلعة
====================

Kal3a is a platform for collecting social media artifacts.

Currently, Kal3a suports Twitter and PubSub notifications. All input is transformed into [Atom entries](https://tools.ietf.org/html/rfc4287) for indexing. Original data is also retained.

## Software Requirements

* [PHP 7.0](http://php.net)
* [Composer](https://getcomposer.org)
* [MySQL](http://dev.mysql.com/downloads/)
* [CouchDB 1.6](http://couchdb.apache.org)
* [Elasticsearch 2.0](https://www.elastic.co/products/elasticsearch)
* [Logstash 2.1](https://www.elastic.co/products/logstash)
* [RabbitMQ 3.6](https://www.rabbitmq.com)

Kal3a requires multiple long-running processes, so a process manager is advised. For development, you should consider
[Invoker](http://invoker.codemancers.com). An example configuration for invoker is included. For production, you should
consider [Supervisor](http://supervisord.org).

Although there are many dependencies, you can rely on distribution packages and their default configuration during
development. Some of the listed dependencies have dependencies of their own which are not listed here.

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
* `composer install` This installs all the PHP dependencies and then asks you for some configuration details. You can
  safely accept the default value for every choice.
* Run `bin/console server:run` and visit `http://localhost:8000` to confirm that the basic install is complete.

### Maintenance

SYMFONY_ENV=prod

Run daily:

```bash
bin/console castle:prune
```

Run hourly with each task staggered by 5 minutes:

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


## Exporting

```bash
bin/console castle:export [tag] [start-date] [end-date] -o export.json
```

