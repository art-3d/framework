FROM php:8.3-fpm

WORKDIR /app

RUN apt-get update \
&& apt-get install -y zip unzip libzip-dev default-mysql-client \
&& docker-php-ext-install zip pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
