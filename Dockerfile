FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libxml2-dev libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring tokenizer xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

RUN mkdir -p database && touch database/database.sqlite

RUN chmod -R 775 storage bootstrap/cache database

RUN if [ ! -f .env ]; then cp .env.example .env; fi

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear

RUN php artisan key:generate

EXPOSE 80
