FROM php:8.0-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -yqq --no-install-recommends \
    curl \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    vim \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install memcached redis xdebug \
    && docker-php-ext-install bcmath pdo_mysql pdo_pgsql soap sockets zip intl pcntl \
    && docker-php-ext-enable memcached redis xdebug

WORKDIR /var/www/exercism

