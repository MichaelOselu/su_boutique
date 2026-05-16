FROM php:8.2-cli

WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql

# Copy application
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install frontend dependencies
RUN npm install

# Build Vite assets
RUN npm run build

# Create storage link
RUN php artisan storage:link || true

# Expose Render port
EXPOSE 10000

# Start app
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
