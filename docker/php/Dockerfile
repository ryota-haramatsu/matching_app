FROM php:7.4.1-fpm

# php.iniをコピー
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

# Composer install
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

#node.js install
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    libpq-dev \
    libfreetype6-dev \ 
    zlib1g-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-install pdo_mysql bcmath \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd 

WORKDIR /var/www/html