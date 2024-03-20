# Use the official PHP image with PHP-FPM
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install other PHP extensions
RUN docker-php-ext-install \
    zip \
    pcntl \
    sockets \
    pdo_mysql\
    mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory to /var/www
WORKDIR /data

# Define volume
VOLUME /data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
