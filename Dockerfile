FROM php:8.2-apache

# Extensións SQLite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

RUN docker-php-ext-install pdo pdo_sqlite

# Copiar archivos
COPY src/ /var/www/html/
# Copiar SQLite
COPY database.sqlite /var/www/html/database.sqlite

# Permisos
RUN chown -R www-data:www-data /var/www/html
RUN chmod 666 /var/www/html/database

