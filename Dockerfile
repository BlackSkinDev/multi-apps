# base image
FROM php:8.1-fpm-alpine

# set working directory
WORKDIR /var/www/html

# install dependencies
RUN apk update && apk add --no-cache \
    bash \
    libzip-dev \
    zip \
    libpng-dev \
    npm \
    yarn \
    && docker-php-ext-install pdo_mysql zip gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# copy source code
COPY . .

# install composer dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# install npm dependencies
RUN npm install && npm run dev

# run migrations
RUN php artisan migrate --force

# set permissions for storage and cache directories
RUN chmod -R 777 storage bootstrap/cache

# expose port 9000 (for PHP-FPM)
EXPOSE 9000

# start PHP-FPM
CMD ["php-fpm"]
