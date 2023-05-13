FROM php:8.1-fpm-alpine

# Set Laravel environment variables
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Install additional dependencies
RUN apk add --no-cache \
    bash \
    libzip-dev \
    zip \
    libpng-dev \
    npm \
    yarn \
    && docker-php-ext-install pdo_mysql zip gd

# Copy application files
COPY . /var/www/html/

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Run any additional commands you need to prepare the environment (e.g. install dependencies)
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 (for PHP-FPM)
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
