FROM php:8.4-fpm

# Install PDO MySQL extension
RUN docker-php-ext-install pdo_mysql

# Install Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \