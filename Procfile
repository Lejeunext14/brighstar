web: php -S 0.0.0.0:$PORT public/index.php
release: composer install --no-dev --prefer-dist && php artisan config:cache && php artisan route:cache && php artisan migrate --force
