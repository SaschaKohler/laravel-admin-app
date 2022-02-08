FROM php:7.4-fpm-alpine

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# persistent / runtime deps
RUN apk add --no-cache \
		acl \
		file \
		gettext \
		git \
		openssl \
		$PHPIZE_DEPS \
		zlib-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libpq-dev \
    ;

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql #pgsql zip pcntl
#RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install exif && docker-php-ext-enable exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-enable opcache

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY docker/laravel/php.ini /usr/local/etc/php/php.ini
COPY docker/laravel/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

# copy init script
COPY docker/laravel/init.sh /usr/local/bin/init
RUN chmod +x /usr/local/bin/init
COPY docker/laravel/seed.sh /usr/local/bin/seed
RUN chmod +x /usr/local/bin/seed

RUN addgroup -S -g "$PGID" okami101 && adduser -S -u "$PUID" user -G okami101

USER user


WORKDIR /srv/api

CMD ["php-fpm"]

EXPOSE 9000
