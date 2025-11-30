FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/html

COPY public/ /var/www/html/

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]

EXPOSE 8080
