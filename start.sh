#!/bin/sh
# start.sh

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

chmod +x start.sh
