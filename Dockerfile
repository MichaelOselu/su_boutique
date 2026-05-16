FROM php:8.2-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

COPY . .

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear Laravel cache BEFORE anything
RUN php artisan optimize:clear

# Run migrations ONLY (NOT seed in production builds)
RUN php artisan migrate --force

# Install frontend dependencies
RUN npm install

# Build Vite assets (IMPORTANT)
RUN npm run build

# Re-cache Laravel for production
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
