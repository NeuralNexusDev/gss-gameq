FROM php:7.4-apache

COPY src/GameQ/ /var/www/html/

COPY src/gameq-server.php /var/www/html/
