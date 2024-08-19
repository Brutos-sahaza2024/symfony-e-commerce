FROM php:8.2-fpm

# Install system dependencies and PHP extensions in one step to reduce layers
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd intl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Ensure www-data has ownership of the application files and full permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Create .composer directory and set permissions
RUN mkdir -p /var/www/.composer \
    && chown -R www-data:www-data /var/www/.composer \
    && chmod -R 755 /var/www/.composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
