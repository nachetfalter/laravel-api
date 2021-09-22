#!/bin/bash
set -e

cd /var/www/simple_laravel_api

exec php-fpm & composer install & php artisan migrate --force & php artisan serve --host=0.0.0.0
