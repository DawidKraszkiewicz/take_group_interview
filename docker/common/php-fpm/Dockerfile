FROM php:8.4-fpm-alpine

RUN apk update && apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    libxml2-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    sqlite-dev \
    oniguruma-dev \
    linux-headers \
    $PHPIZE_DEPS

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_sqlite mbstring pcntl bcmath xml

WORKDIR /var/www/html
