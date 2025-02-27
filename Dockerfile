# Use PHP 8.2 CLI image
FROM php:8.2-cli

# Install system dependencies (for Laravel)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    libzip-dev \
    curl \
    && apt-get clean

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory inside the container
WORKDIR /var/www/html

# Expose port 8000 for Laravel's built-in server
EXPOSE 8000

# Run the Laravel built-in server
CMD php artisan serve --host=0.0.0.0 --port=8000
