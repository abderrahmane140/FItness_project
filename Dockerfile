FROM php:8.2-apache

# Install mysqli and pdo_mysql
RUN docker-php-ext-install mysqli 
RUN docker-php-ext-enable mysqli 

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

EXPOSE 80
