FROM php:8.2-apache

# Instala dependências básicas necessárias para o Laravel + SQLite e extensões PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring tokenizer xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copia o Composer oficial para dentro do container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia o código da aplicação
COPY . /var/www/html

WORKDIR /var/www/html

# Ajusta permissões para o usuário www-data (apache)
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Cria arquivo SQLite caso não exista
RUN mkdir -p database && touch database/database.sqlite

# Dá permissões para storage, cache e database
RUN chmod -R 775 storage bootstrap/cache database

# Se .env não existir, copia o exemplo
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Instala dependências Laravel, limpa cache e gera APP_KEY
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:clear \
    && php artisan key:generate

# Expõe porta 80
EXPOSE 80
