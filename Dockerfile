# Base image
FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    libmcrypt-dev \
    libicu-dev \
    libxml2-dev \
    zlib1g-dev \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mbstring pdo pdo_mysql zip intl xml opcache bcmath soap pcntl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY . /var/www/html

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader

# Install NPM packages
RUN npm install

# Build the Vue app
RUN npm run prod

# Run database migrations
RUN php artisan migrate

# Expose port
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
