FROM composer:2.7.2 AS build
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --ignore-platform-reqs

COPY . .
RUN composer dumpautoload --optimize

FROM php:8.2-apache AS production
WORKDIR /app

RUN apt update && \
    apt install -y \
    libbz2-dev \
    libxml2-dev && \
    apt purge -y --auto-remove

RUN docker-php-ext-install \
    bz2 \
    xml

COPY --from=build /app/src /var/www/html/
COPY --from=build /app/vendor /var/www/html/vendor/
