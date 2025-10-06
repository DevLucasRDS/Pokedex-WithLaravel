# Imagem base com PHP e extensões necessárias
FROM php:8.2-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Instala extensões PHP necessárias pro Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Copia todos os arquivos do projeto pro container
COPY . .

# Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Dá permissão nas pastas de storage e cache
RUN chmod -R 777 storage bootstrap/cache

# Gera a chave do Laravel
RUN php artisan key:generate

# Expõe a porta usada pelo PHP-FPM
EXPOSE 8000

# Comando que inicia o servidor Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
