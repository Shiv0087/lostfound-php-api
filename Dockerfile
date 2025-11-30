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

COPY public/ /app

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app"]

EXPOSE 80
