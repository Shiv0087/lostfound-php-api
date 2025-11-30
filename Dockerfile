FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your public folder into Apache root
COPY public/ /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
