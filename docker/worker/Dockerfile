FROM php:7.1

RUN apt-get update

RUN apt-get install -y libmemcached-dev mysql-client zlib1g-dev

RUN pecl install memcached && docker-php-ext-enable memcached

RUN docker-php-ext-install bcmath pdo pdo_mysql
