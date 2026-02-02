##!/bin/sh
# start.sh

# Optional: Clear Laravel caches at runtime
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
php artisan optimize

# Run Laravel development server
php artisan serve --host=0.0.0.0 --port=$PORT
