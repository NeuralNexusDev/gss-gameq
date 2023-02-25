FROM php:7.4-apache

COPY src/gameq /var/www/html/

COPY src/gameq-server.php /var/www/html/
