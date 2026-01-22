FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl nginx

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup Nginx and Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/cache
# (You'll also need to copy a basic nginx config here)

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]