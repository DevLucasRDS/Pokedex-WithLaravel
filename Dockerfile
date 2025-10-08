# usa uma imagem que já contém nginx + php-fpm
FROM richarvey/nginx-php-fpm:latest

# Variáveis de ambiente para configurar a imagem
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Copia o código para o container
COPY . /var/www/html

# Permissões (ajuste se necessário)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Start padrão da imagem (inicia nginx + php-fpm)
CMD ["/start.sh"]
