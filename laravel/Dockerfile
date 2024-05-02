FROM composer:2.6.6 as composer
FROM mlocati/php-extension-installer:2.1.75 as installer
FROM php:8.3.1-cli-alpine

#----------------------------------------------------------

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY --from=installer /usr/bin/install-php-extensions /usr/local/bin/install-php-ext

RUN apk add --no-cache git unzip bash

RUN install-php-ext pdo_mysql zip bcmath exif sockets pcntl xdebug

RUN mkdir -p /var/www/html
RUN mkdir -p /var/www/html/vendor

WORKDIR /var/www/html
