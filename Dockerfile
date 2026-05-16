FROM php:8.2-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy project files
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear config cache
RUN php artisan config:clear

# Expose port Render uses
EXPOSE 10000

# Start Laravel server
CMD php artisan serve --host=0.0.0.0 --port=10000

RUN php artisan storage:link || true
RUN php artisan migrate --force || true
