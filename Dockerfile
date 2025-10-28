FROM php:8.2-fpm

# Set working directory
WORKDIR /workspace

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    apache2 \
    libapache2-mod-fcgid \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .
RUN ls -la /workspace

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Apache configuration
COPY docker/apache/000-default.conf /etc/apache2/sites-available/laravel.conf
RUN a2dissite 000-default.conf
RUN a2enmod rewrite
RUN a2enmod proxy_fcgi
RUN a2enmod setenvif
RUN a2ensite laravel.conf

# Set permissions
RUN chown -R www-data:www-data /workspace \
    && chmod -R 755 /workspace/storage \
    && chmod -R 755 /workspace/bootstrap/cache

# Expose port 80 for Apache
EXPOSE 80

# Start Apache and PHP-FPM
CMD ["apache2ctl", "-D", "FOREGROUND"]
