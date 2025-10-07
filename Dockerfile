FROM php:8.2-fpm

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Instalar extensões PHP (incluindo PostgreSQL)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar o projeto
COPY . .

# Instalar dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Permissões de pasta
RUN chmod -R 777 storage bootstrap/cache

# Gerar APP_KEY automaticamente
RUN php artisan key:generate

# Rodar migrations e populador automaticamente
CMD php artisan migrate --force && php artisan Pokemon:populate && php artisan serve --host=0.0.0.0 --port=8000
