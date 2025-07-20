RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring tokenizer xml \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala o Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copia o código para dentro do container
COPY . /var/www/html

WORKDIR /var/www/html

# Permissões de pasta
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache database

# Prepara ambiente Laravel
RUN if [ ! -f .env ]; then cp .env.example .env; fi
RUN composer install --optimize-autoloader --no-dev
RUN php artisan key:generate
RUN touch database/database.sqlite

# Porta exposta
EXPOSE 80
