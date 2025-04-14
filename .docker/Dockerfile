# Use an official PHP image with Apache as the base image.
FROM php:8.3-apache

# Set environment variables.
ENV ACCEPT_EULA=Y
LABEL maintainer=""

# Install system dependencies.
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    mc \
    net-tools \
    aspell aspell-en aspell-de \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules required for Laravel.
RUN a2enmod rewrite

# Set the Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/phpsitespellchecker

# Update the default Apache site configuration
COPY .docker/apache-config.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/laravel-worker.conf /etc/supervisor/conf.d
COPY .docker/de-neu.multi /usr/lib/aspell
COPY .docker/en.multi /usr/lib/aspell

RUN chmod -R 777 .docker/start.sh
RUN chmod -R 777 .docker/completeinstall.sh

# Install PHP extensions.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql

# Install Composer globally.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a directory for your Laravel application.
WORKDIR /var/www/html/phpsitespellchecker

# Copy the Laravel application files into the container.
COPY . .

COPY .docker/.env /var/www/html/phpsitespellchecker

# Install Laravel dependencies using Composer.
RUN composer install --no-interaction --optimize-autoloader


# Set permissions for Laravel.
RUN chown -R www-data:www-data storage bootstrap/cache

RUN chmod -R 777 storage
RUN chmod -R 777 dict


RUN php artisan key:generate

# Expose port 80 for Apache.
EXPOSE 80

RUN mv vendor /tmp/vendor

# Start Apache web server supervisor and some final steps.
CMD [".docker/start.sh"]

