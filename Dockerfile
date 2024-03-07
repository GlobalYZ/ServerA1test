# Use an official PHP runtime as a base image
FROM php:7.4-apache

# Install git and Composer
RUN apt-get update && apt-get install -y git

RUN apt-get install -y libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite

RUN chown -R www-data:www-data /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache Rewrite Module
RUN a2enmod rewrite

# Copy source code into the container
COPY . /var/www/html/

RUN chmod o+w /var/www/html/A1.sqlite

# Run composer install
# RUN composer install

# Expose port 80 to the outside world
EXPOSE 80