FROM php:8.2-apache

# Install dependencies for GD and zip/unzip
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libgd-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip

# Copy Composer binary
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 1. Copy dependency files first
COPY composer.json composer.lock* ./

# 2. Download dependencies without building the autoloader yet
RUN composer install --no-dev --no-scripts --no-autoloader

# 3. Copy source files
COPY src/ ./

# 4. Dump autoloader AFTER source files are copied
RUN composer dump-autoload --optimize

# Set file permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
