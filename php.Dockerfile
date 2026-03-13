# Use PHP with Apache
FROM php:8.2-apache

# Install PDO MySQL and other necessary extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite for nice URLs if needed
RUN a2enmod rewrite

# Configure PHP settings to allow $_ENV to be populated from the system
RUN echo "variables_order = \"EGPCS\"" >> /usr/local/etc/php/conf.d/custom-php.ini

# Enable AllowOverride All for .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
