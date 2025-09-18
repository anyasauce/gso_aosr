# Use the official PHP image with Apache
FROM php:8.2-apache

# Install mysqli and pdo_mysql extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your PHP source code to the Apache document root
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

# Start Apache server (this is default command in the php:apache image)
CMD ["apache2-foreground"]
