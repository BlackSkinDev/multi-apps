# Use an official PHP runtime as a parent image
FROM php:8.1-fpm-alpine

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    bash \
    nginx \
    supervisor \
    nodejs \
    npm \
    yarn

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Copy nginx config file
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Copy supervisor config files
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy application files
COPY . /var/www/html/

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install composer dependencies
RUN composer install --no-dev --no-scripts --no-progress --prefer-dist --optimize-autoloader

# Build Vue.js assets
RUN yarn install --frozen-lockfile
RUN yarn production

# Set Laravel environment variables
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Copy entrypoint script
COPY ./docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose ports
EXPOSE 80

# Run supervisord
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
