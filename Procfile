web: composer install --no-dev --prefer-dist && npm ci && npm run build && php artisan config:cache && php artisan route:cache && php -S 0.0.0.0:$PORT public/index.php
release: php artisan migrate --force
