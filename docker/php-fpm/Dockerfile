FROM php:8.3.0-fpm-alpine

# Install packages
RUN apk add --no-cache curl git build-base zlib-dev oniguruma-dev autoconf bash libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Configure non-root user.
RUN apk --no-cache add shadow && \
    groupmod -o -g 1000 www-data && \
    usermod -o -u 1000 -g www-data www-data

# Source code
COPY ./ /var/www
WORKDIR /var/www

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php-fpm

EXPOSE 9000
