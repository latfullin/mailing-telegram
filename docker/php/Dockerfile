FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    procps \
    autoconf \
    build-base \
    libzip-dev \
    libxml2-dev \
    libmcrypt-dev \
    libgcrypt-dev \
    curl \
    tzdata

# Install Pecl extension
RUN pecl install redis \
    mcrypt \
    xdebug && \
    docker-php-ext-enable redis \
    mcrypt \
    xdebug

# Install extension
RUN docker-php-ext-configure zip && \
    docker-php-ext-install zip \
    pdo \
    pdo_mysql \
    opcache \
    pcntl \
    sockets \
    bcmath

# PHP CLI - config
#COPY ./config/php.ini-production $PHP_INI_DIR/conf.d/php_custom.ini

# PHP FPM - config
COPY ./config/www.conf $PHP_INI_DIR/../php-fpm.d/www_custom.conf

# Set time zone System
RUN cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime
RUN echo "Europe/Moscow" > /etc/timezone

# Time Zone PHP
RUN echo "Europe/Moscow" > $PHP_INI_DIR/conf.d/timezone.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Config Xdebug extension
COPY ./config/xdebug.ini $PHP_INI_DIR/conf.d/xdebug.ini

# Clear
RUN docker-php-source delete \
    && rm -rf /tmp/* \
    && rm -rf /var/cache/apk/*

WORKDIR /var/www/html

# SET USER
ARG DOCKER_USER
ARG DOCKER_UID
ARG DOCKER_GROUP
ARG DOCKER_GID

ENV DOCKER_USER=$DOCKER_USER
ENV DOCKER_UID=$DOCKER_UID
ENV DOCKER_GROUP=$DOCKER_GROUP
ENV DOCKER_GID=$DOCKER_GID

# Create system user
RUN addgroup -g $DOCKER_GID $DOCKER_GROUP
RUN adduser -G www-data -u $DOCKER_UID -D -h /home/$DOCKER_USER $DOCKER_USER

# Set PHP user
RUN echo "user = $DOCKER_USER" >> $PHP_INI_DIR/../php-fpm.d/www_custom.conf
RUN echo "group = $DOCKER_GROUP" >> $PHP_INI_DIR/../php-fpm.d/www_custom.conf

USER $DOCKER_USER:$DOCKER_GROUP

# CMD ["php-fpm"]
