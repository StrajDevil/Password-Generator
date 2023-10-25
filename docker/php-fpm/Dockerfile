FROM php:8.2-fpm-alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -xe; \
    apk add --update linux-headers && \
    apk add bash libzip-dev zip unzip mariadb-client gmp-dev

RUN apk update && apk add && docker-php-ext-install pdo pdo_mysql mysqli zip pcntl gmp

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install xdebug redis \
    && docker-php-ext-enable redis.so \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_nesting_level = 256" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request = trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log = '/var/log/xdebug.log'" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN touch /var/log/xdebug.log && chmod 777 /var/log/xdebug.log

ADD ./startup.sh /opt/startup.sh

EXPOSE 9000
CMD ["/bin/bash", "/opt/startup.sh"]
