FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files into container
COPY public/ /var/www/html/

# Expose port 8080 that Railway uses
EXPOSE 8080

# Change Apache port from 80 → 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

CMD ["apache2-foreground"]
