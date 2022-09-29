#
## Build
FROM php:8.1-fpm-alpine as php

# Install system dependencies
RUN apk update --no-cache \
	&& apk add \
	icu-dev \
	oniguruma-dev \
	tzdata

# Install PHP extensions
RUN docker-php-ext-install intl pdo_mysql mbstring

# Clear cache
RUN rm -rf /var/cache/apk/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/app

# Composer install
COPY composer.* .
RUN composer install

# Copy source
COPY *.php .
COPY .serverless .
COPY serverless.yml .

# Run Application
#EXPOSE 8090
#CMD ["php", "-S", "0.0.0.0:8090"]



##
## Deploy
FROM node:16 as deploy

ARG AWS_KEY
ARG AWS_SECRET

WORKDIR /app

COPY --from=php /var/www/app/ /app

RUN npm install -g serverless

RUN serverless config credentials --provider aws --key ${AWS_KEY} --secret ${AWS_SECRET}

RUN serverless deploy
