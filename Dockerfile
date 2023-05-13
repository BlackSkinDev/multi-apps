FROM richarvey/nginx-php-fpm:1.7.2

# Set Laravel environment variables
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Copy application files
COPY . /var/www/html/

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Run any additional commands you need to prepare the environment (e.g. install dependencies)

CMD ["/start.sh"]
