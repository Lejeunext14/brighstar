FROM php:8.4-fpm

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev

# 2. Install PHP extensions (Added zip and intl for Composer)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 3. Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .


# Add --no-scripts to skip the 'package:discover' step during build
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

# 5. Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Render uses the PORT env var, but artisan serve defaults to 8000
CMD php artisan serve --host=0.0.0.0 --port=$PORT