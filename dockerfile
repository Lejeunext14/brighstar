# Use PHP 8.2 or 8.3 (Laravel 12 requirement)
FROM php:8.4-fpm

# Install system dependencies and PostgreSQL drivers
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache && chown -R www-data:www-data /var/www

# Expose port 10000 for Render
EXPOSE 10000

# Start the PHP server
CMD php artisan serve --host=0.0.0.0 --port=10000