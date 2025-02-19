FROM php:8.0-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath

COPY php /var/www/html/php
COPY css /var/www/html/css
COPY csv /var/www/html/csv
COPY download /var/www/html/download
COPY fonts /var/www/html/fonts
COPY img /var/www/html/img
COPY js /var/www/html/js

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

RUN a2enmod rewrite

EXPOSE 80
