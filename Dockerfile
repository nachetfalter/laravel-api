FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    lsof \
    httpie \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy over app content
COPY . /var/www/simple_laravel_api

# Create a .env file
RUN touch .env

# Set working directory
WORKDIR /var/www/simple_laravel_api

RUN composer install

USER root

RUN chmod +x /var/www/simple_laravel_api/entrypoint.sh

# Expose port 8000 and start php-fpm server
EXPOSE 8000

ENTRYPOINT ["/var/www/simple_laravel_api/entrypoint.sh"]
