# Imagem base com PHP, Apache e extensões comuns
FROM php:8.2-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o projeto Laravel
COPY . /var/www/html

# Definir diretório de trabalho
WORKDIR /var/www/html

# Permitir que o Apache acesse os arquivos corretamente
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Criar o banco SQLite se não existir
RUN mkdir -p database && touch database/database.sqlite

# Configurar permissões
RUN chmod -R 775 storage bootstrap/cache database

# Copiar o arquivo .env (caso queira copiar um de exemplo)
# COPY .env.example .env

# Rodar dependências Laravel e gerar chave
RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:clear && \
    php artisan key:generate

# Expor a porta 80 (padrão do Apache)
EXPOSE 80
