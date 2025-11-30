# Dockerfile — use Apache + PHP with mysqli, pdo_mysql
FROM php:8.2-apache

# Install system libs and php extensions we need
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
 && docker-php-ext-install mysqli pdo pdo_mysql \
 && a2enmod rewrite

# Copy public folder into Apache document root
COPY public/ /var/www/html/

# Make sure Apache uses index.php as directory index (usually default)
# Expose port 80 (Railway expects http on 80)
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
