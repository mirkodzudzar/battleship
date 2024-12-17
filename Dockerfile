FROM php:8.3 AS php

# Install required dependencies and PHP extensions
RUN apt-get update -y \
    && apt-get install -y --no-install-recommends unzip libpq-dev libcurl4-gnutls-dev netcat-traditional \
    && apt-get install -y --no-install-recommends libedit-dev libreadline-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis \
    && docker-php-source extract \
    && docker-php-ext-install pcntl \
    && docker-php-source delete \
    && rm -rf /var/lib/apt/lists/* /tmp/pear

WORKDIR /var/www
COPY . .

COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "docker/entrypoint.sh" ]

# ================================================================
# node
FROM node:20-alpine AS node

WORKDIR /var/www
COPY . .

RUN npm install --global cross-env
RUN npm install

VOLUME /var/www/node_modules
