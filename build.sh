#!/bin/bash
set -e

echo "Installing Composer dependencies..."
composer install --no-dev --prefer-dist --ignore-platform-reqs

echo "Installing NPM dependencies..."
npm ci

echo "Building assets..."
npm run build

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache

echo "✅ Build complete!"
