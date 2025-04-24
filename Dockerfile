FROM php:8.1-fpm

# Install system dependencies and Node.js
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    # Add Node.js repository and install Node.js
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Create directory for the application
RUN mkdir -p /var/www

# Set permissions for composer
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Copy package files first
COPY package*.json ./
RUN npm install

# Copy composer files
COPY composer.json composer.lock ./

# Set ownership for copied files
RUN chown -R www-data:www-data .

# Install dependencies as www-data with verbose output
USER www-data
RUN composer install --no-scripts --no-autoloader -v

# Copy existing application directory
USER root
COPY . .
RUN chown -R www-data:www-data .

RUN npm install

# Build frontend assets
RUN npm run build

# Generate optimized autoload files as www-data
USER www-data
RUN composer dump-autoload --optimize

# Create storage directory structure
USER root
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && chown -R www-data:www-data storage \
    && chmod -R 775 storage

# Generate key
USER www-data
RUN php artisan key:generate

USER root
# Ensure correct permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]