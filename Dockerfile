# 1. Imagem base: PHP 8.2 com Apache pré-instalado
FROM php:8.2-apache

# 2. Atualiza lista de pacotes e instala dependências necessárias para Laravel e SQLite
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Copia o Composer (gerenciador de dependências PHP) da imagem oficial do Composer para dentro da imagem
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Copia todo o código da aplicação para a pasta padrão do Apache dentro do container
COPY . /var/www/html

# 5. Define que a pasta padrão onde o container vai trabalhar é essa
WORKDIR /var/www/html

# 6. Ajusta permissões para que o servidor web possa acessar os arquivos e ativa o módulo rewrite do Apache (necessário para Laravel)
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# 7. Cria o arquivo do banco SQLite, caso não exista (evita erro)
RUN mkdir -p database && touch database/database.sqlite

# 8. Dá permissões corretas para as pastas usadas para cache e armazenamento no Laravel
RUN chmod -R 775 storage bootstrap/cache database

# 9. Instala as dependências PHP do Laravel sem os pacotes de desenvolvimento, otimiza o autoload, limpa cache de configuração e gera a chave da aplicação
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:clear \
    && php artisan key:generate

# 10. Expõe a porta 80, que é a padrão do Apache, para acessar externamente
EXPOSE 80
