FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql

COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

RUN php artisan migrate --force
RUN php artisan db:seed --force
# Install frontend deps + build Vite
RUN npm install
RUN npm run build

RUN php artisan config:clear

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
