#Build Composer dependencies
FROM composer as composer

COPY database/ database/
COPY tests/ tests/
COPY composer.json /app
COPY composer.lock /app

RUN composer install --ignore-platform-reqs --no-scripts


#Build Final Image
FROM php:8.1-apache

#Memcached Installation
RUN apt-get update && apt-get install -y libz-dev libmemcached-dev && rm -r /var/lib/apt/lists/*
RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

#ADD ./php/php.ini /usr/local/etc/php/conf.d
ADD . /var/www
ADD ./public /vaw/www/html

COPY --from=composer /app/vendor /var/www/vendor


WORKDIR /var/www

RUN chmod -R 777 /var/www/storage \
    && chmod -R 777 /var/www/bootstrap/cache \
    && chmod -R 777 /var/www/storage/framework/sessions \
    && chmod -R 777 /var/www/storage/framework/views
