FROM php:7.1

RUN apt-get update

RUN apt-get install -y libmemcached-dev mysql-client zlib1g-dev

RUN pecl install memcached && docker-php-ext-enable memcached

RUN pecl install apcu && docker-php-ext-enable apcu

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-install bcmath opcache pdo pdo_mysql
