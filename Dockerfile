# Use the official PHP base image
FROM php:8.1

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy application files
COPY . .

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts

# Expose the port
EXPOSE 8080

# Define the command to run your Laravel application
CMD php artisan serve --host=0.0.0.0 --port=8080
