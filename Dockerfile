# 1. Imagem base: PHP 8.2 com Apache
FROM php:8.2-apache

# 2. Atualiza lista de pacotes e instala dependências necessárias para Laravel, SQLite e extensões PHP essenciais
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring tokenizer xml xmlwriter \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Copia o Composer da imagem oficial para o container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copia o código do projeto para o diretório padrão do Apache
COPY . /var/www/html

# 5. Define o diretório de trabalho
WORKDIR /var/www/html

# 6. Ajusta permissões para o servidor web e habilita mod_rewrite
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# 7. Cria o arquivo do banco SQLite, caso não exista
RUN mkdir -p database && touch database/database.sqlite

# 8. Ajusta permissões para storage, cache e database
RUN chmod -R 775 storage bootstrap/cache database

# 9. Se o arquivo .env não existir, cria copiando o exemplo
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# 10. Instala dependências do Laravel, limpa cache e gera a chave da aplicação
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:clear \
    && php artisan key:generate

# 11. Expõe a porta 80 para acesso HTTP
EXPOSE 80
