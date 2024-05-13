FROM php:8.3-apache
WORKDIR /var/www/html

RUN chown -R www-data:www-data .

# Mod Rewrite
RUN a2enmod rewrite

# Linux Library
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP Extension
RUN docker-php-ext-install mysqli pdo pdo_mysql \
         && docker-php-ext-enable pdo_mysql

