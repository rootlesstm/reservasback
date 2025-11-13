FROM php:8.3-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpq-dev unzip zip && \
    docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Instalar dependencias de Laravel
RUN composer global require laravel/installer

#CMD ["php-fpm"]

ENV PORT=8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]


