#!/bin/sh

set -e

# Ensure storage & cache directories are writable
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ensure log file exists and is writable
touch storage/logs/laravel.log
chown www-data:www-data storage/logs/laravel.log
chmod 664 storage/logs/laravel.log


#Clear Laravel caches at runtime
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize

# Run Laravel development server
exec php -S 0.0.0.0:${PORT:-10000} -t public