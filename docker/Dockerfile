FROM php:8.4-fpm

# Install PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Install Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Add Xdebug configuration
COPY ./../config/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN mkdir -p /var/log && chown -R www-data:www-data /var/log