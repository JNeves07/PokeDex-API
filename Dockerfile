FROM php:8.4-cli-alpine

RUN apk add --no-cache git unzip libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo_sqlite zip mbstring

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && cp .env.example .env \
    && php artisan key:generate \
    && php artisan migrate --seed --force

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
