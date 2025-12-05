FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

# Imposta la DocumentRoot a /var/www/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copia TUTTO il progetto
COPY . /var/www/html/

# Permessi
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
