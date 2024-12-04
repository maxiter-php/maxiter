# Official image of PHP 8.2
FROM php:8.2-apache

####################################

# Dependencies of PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libgpgme-dev \
    curl \
    vim \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring xml zip pdo_pgsql \
    && pecl install gnupg \
    && docker-php-ext-enable gnupg \
    && a2enmod rewrite


# Workspace 
WORKDIR /var/www/html
COPY . /var/www/html

# Apache configuration
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80