# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy your PHP source code to the Apache document root
COPY ./src /var/www/html/

# Expose port 80
EXPOSE 80

# Start Apache server (this is default command in the php:apache image)
CMD ["apache2-foreground"]
