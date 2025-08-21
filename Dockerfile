FROM php:8.1-apache

# Copy proxy script to Apache web root
COPY public/ /var/www/html/

# Optional: Enable mod_rewrite if needed
RUN a2enmod rewrite

EXPOSE 80
