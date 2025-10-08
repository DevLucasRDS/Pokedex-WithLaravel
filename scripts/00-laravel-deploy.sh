#!/usr/bin/env bash
set -e

cd /var/www/html

# Composer install (sem dev para reduzir tamanho)
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Permissões
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# Cache e otimizações
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Rodar migrations (force)
php artisan migrate --force

