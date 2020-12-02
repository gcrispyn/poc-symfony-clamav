ARG NGINX_VERSION=1.19.4
ARG PHP_VERSION=7.4.9

######### PHP #########

FROM php:${PHP_VERSION}-fpm-alpine as clamav_php

# persistent / runtime deps
RUN apk add --no-cache acl;
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY docker/php/conf.d/symfony.ini $PHP_INI_DIR/conf.d/
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

RUN chmod +x /usr/local/bin/docker-entrypoint

ENV APP_ENV=dev

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

#########################

######### NGINX #########

FROM nginx:${NGINX_VERSION}-alpine as clamav_nginx

COPY docker/nginx/conf.d/default.conf.template /etc/nginx/templates/

WORKDIR /var/www/html

#########################