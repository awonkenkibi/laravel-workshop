# Use official PHP 8.2 FPM image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies + Node.js & npm
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Install Node dependencies & build Vite assets
RUN npm install
RUN npm run build

# Set permissions for storage and cache
RUN chmod -R 777 storage bootstrap/cache

# Expose port
ENV PORT 10000
EXPOSE $PORT

# Start Laravel server at runtime (Render will override CMD)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
