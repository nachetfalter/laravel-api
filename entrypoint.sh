#!/bin/bash
set -e

cd /var/www/simple_laravel_api

exec php-fpm &
    composer install
    npm install
    php artisan migrate --force
    npm run watch &
    php artisan serve --host=0.0.0.0
