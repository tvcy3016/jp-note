FROM php:8.3-fpm-bookworm

WORKDIR /var/www/html

COPY . .

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]