FROM php:8.4-cli

# 安裝 PostgreSQL driver
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t /var/www/html/public"]