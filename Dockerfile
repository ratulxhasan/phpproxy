FROM php:8.1-apache

# Copy proxy script to Apache web root
COPY public/ /var/www/html/

# Set proxy.php as default entry point
RUN echo "DirectoryIndex proxy.php" >> /etc/apache2/apache2.conf

# Optional: Enable mod_rewrite
RUN a2enmod rewrite

EXPOSE 80
